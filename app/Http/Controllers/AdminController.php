<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\Page;
use App\Models\Link;
use App\Models\View;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' =>[
            'login',
            'loginAction',
            'register',
            'registerAction'
        ]]);
    }

    public function login(Request $request)
    {
        return view('admin/login', [
            'error' => $request->session()->get('error')
        ]);
    }

    public function loginAction(Request $request)
    {
        $creds = $request->only('email', 'password');
        $validator = Validator::make($creds, [
            'email' => ['required', 'string', 'email', 'max:100'],
            'password' => ['required', 'string', 'min:4'],
        ]);
        if($validator->fails()) {
            return redirect('/admin/login')
                ->withErrors($validator)
                ->withInput();
        }
        if(Auth::attempt($creds)) {
            return redirect('/admin');
        } else {
            $validator->errors()->add('password', 'E-mail e/ou senha inválidos!');
            return redirect()->route('login')
                ->withErrors($validator)
                ->withInput();
        }
    }

    public function register(Request $request)
    {
        return view('admin/register', [
            'error' => $request->session()->get('error')
        ]);
    }

    public function registerAction(Request $request)
    {
        $creds = $request->only(
            'name',
            'email',
            'password',
            'password_confirmation'
        );
        $validator = Validator::make($creds, [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
        ]);
        if($validator->fails()) {
            return redirect('/admin/register')
                ->withErrors($validator)
                ->withInput();
        }

        $newUser = new User();
        $newUser->name = $creds['name'];
        $newUser->email = $creds['email'];
        $newUser->password = password_hash($creds['password'], PASSWORD_DEFAULT);
        $newUser->save();

        Auth::login($newUser);
        return redirect('/admin');

    }

    public function logout()
    {
        Auth::logout();
        return redirect('/admin');
    }

    public function pages()
    {
        $user = Auth::user();
        $pages = Page::where('id_user', $user->id)->get();

        return view('admin/pages', [
            'pages' => $pages
        ]);
    }

    public function newPage()
    {
        $user = Auth::user();
        $pages = Page::where('id_user', $user->id)->get();

        return view('admin/newpage', [
            'user' => $user,
            'pages' => $pages
        ]);
    }

    public function newPageAction(Request $request)
    {
        $user = Auth::user();
        $page = new Page();
        $pages = Page::where('id_user', $user->id)->get();

        $fields = $request->validate([
            'op_title' => ['required', 'min:2'],
            'op_description' => ['required', 'min:10'],
            'slug' => ['required', 'min:2', 'unique:pages'],
        ]);
        $page->id_user = $user->id;
        $page->op_bg_type = 'color';
        $page->op_title = $fields['op_title'];
        $page->op_description = $fields['op_description'];
        $page->slug = $fields['slug'];
        $page->op_profile_image = 'default.png';
        $page->op_bg_value = '#000000,#FFFFFF';
        $page->save();

        return redirect('/admin/'.$page->slug.'/design');

    }

    public function delPage($idPage)
    {
        $user = Auth::user();
        $page = Page::where('id', $idPage)
            ->where('id_user', $user->id)
            ->first();
        if($page) {
            $link = Link::where('id_page', $page->id)->delete();
            $page->delete();
        }
        return redirect('/admin');
    }

    public function pageLinks($slug)
    {
        $user = Auth::user();
        $page = Page::where('slug', $slug)
            ->where('id_user', $user->id)
            ->first();
        if($page) {
            $links = Link::where('id_page', $page->id)
                ->orderBy('order', 'ASC')
                ->get();

            return view('admin/page_links', [
                'menu' => 'links',
                'page' => $page,
                'links' => $links
            ]);
        } else {
            return redirect('/admin');
        }
    }

    public function linkOrderUpdate($linkid, $pos)
    {
        // Validando se os links pertencem ao usuário logado
        $user = Auth::user();
        $link = Link::find($linkid);
        $mypages = [];
        $myPagesQuery = Page::where('id_user', $user->id)->get();
        foreach($myPagesQuery as $pageItem) {
            $myPages[] = $pageItem->id;
        }
        if(in_array($link->id_page, $myPages)) {
            if($link->order > $pos) {
                //subiu item, jogando os próximos para baixo
                $afterLinks = Link::where('id_page', $link->id_page)
                    ->where('order', '>=', $pos)
                    ->get();
                foreach($afterLinks as $afterLink) {
                    $afterLink->order++;
                    $afterLink->save();
                }
            } elseif($link->order < $pos) {
                // desceu item, jogando os anteriores pra cima
                $beforeLinks = Link::where('id_page', $link->id_page)
                    ->where('order', '<=', $pos)
                    ->get();
                foreach($beforeLinks as $beforeLink) {
                    $beforeLink->order--;
                    $beforeLink->save();
                }
            }
            // Posicionando o item selecionado
            $link->order = $pos;
            $link->save();
            // Corrigindo as posições, será usada a key de um array para acertar a numeração de zero em diante.
            // Ex: teremos casos que a ordem aqui estará -1,0,1 e após ficará 0,1,2 como deve ser.
            $allLinks = Link::where('id_page', $link->id_page)
                ->orderBy('order', 'ASC')
                ->get();
            foreach($allLinks as $linkKey => $linkItem) {
                $linkItem->order = $linkKey;
                $linkItem->save();
            }
        }

        return [];
    }

    public function newLink($slug) {
        $user = Auth::user();
        $page = Page::where('id_user', $user->id)
            ->where('slug', $slug)
            ->first();
        if($page) {
            return view('admin/page_editlink', [
                'menu' => 'links',
                'page' => $page
            ]);
        } else {
            return redirect('/admin');
        }
    }

    public function newLinkAction($slug, Request $request) {
        $user = Auth::user();
        $page = Page::where('id_user', $user->id)
            ->where('slug', $slug)
            ->first();
        if($page) {
            $fields = $request->validate([
                'status' => ['required', 'boolean'],
                'title' => ['required', 'min:2'],
                'href' => ['required', 'url'],
                // inicio com # 0 a 9 e A até F com 3 ou 6 dígitos
                'op_bg_color' => ['required', 'regex:/^[#][0-9A-F]{3,6}$/i'],
                'op_text_color' => ['required', 'regex:/^[#][0-9A-F]{3,6}$/i'],
                'op_border_type' => ['required', Rule::in(['square', 'rounded'])]
            ]);
            $totalLinks = Link::where('id_page', $page->id)->count();

            $newLink = new Link();
            $newLink->id_page = $page->id;
            $newLink->status = $fields['status'];
            $newLink->order = $totalLinks;
            $newLink->title = $fields['title'];
            $newLink->href = $fields['href'];
            $newLink->op_bg_color = $fields['op_bg_color'];
            $newLink->op_text_color = $fields['op_text_color'];
            $newLink->op_border_type = $fields['op_border_type'];
            $newLink->save();

            // Corrigindo as posições
            $allLinks = Link::where('id_page', $page->id)
                ->where('status', 1)
                ->orderBy('order', 'ASC')
                ->get();
            foreach($allLinks as $linkKey => $linkItem) {
                $linkItem->order = $linkKey;
                $linkItem->save();
            }

            return redirect('/admin/'.$page->slug.'/links');

        } else {
            return redirect('/admin');
        }
    }

    public function editLink($slug, $linkid)
    {
        $user = Auth::user();
        $page = Page::where('id_user', $user->id)
            ->where('slug', $slug)
            ->first();
        if($page) {
            $link = Link::where('id_page', $page->id)
                ->where('id', $linkid)
                ->first();
            if($link) {
                return view('admin/page_editlink', [
                    'menu' => 'links',
                    'page' => $page,
                    'link' => $link
                ]);
            }
        }
        return redirect('/admin');
    }

    public function editLinkAction($slug, $linkid, Request $request)
    {
        $user = Auth::user();
        $page = Page::where('id_user', $user->id)
            ->where('slug', $slug)
            ->first();
        if($page) {
            $link = Link::where('id_page', $page->id)
                ->where('id', $linkid)
                ->first();
            if($link) {
                $fields = $request->validate([
                    'status' => ['required', 'boolean'],
                    'title' => ['required', 'min:2'],
                    'href' => ['required', 'url'],
                    // inicio com # 0 a 9 e A até F com 3 ou 6 dígitos
                    'op_bg_color' => ['required', 'regex:/^[#][0-9A-F]{3,6}$/i'],
                    'op_text_color' => ['required', 'regex:/^[#][0-9A-F]{3,6}$/i'],
                    'op_border_type' => ['required', Rule::in(['square', 'rounded'])]
                ]);
                $link->status = $fields['status'];
                $link->title = $fields['title'];
                $link->href = $fields['href'];
                $link->op_bg_color = $fields['op_bg_color'];
                $link->op_text_color = $fields['op_text_color'];
                $link->op_border_type = $fields['op_border_type'];
                $link->save();

                // Corrigindo as posições
                $allLinks = Link::where('id_page', $page->id)
                    ->where('status', 1)
                    ->orderBy('order', 'ASC')
                    ->get();
                foreach($allLinks as $linkKey => $linkItem) {
                    $linkItem->order = $linkKey;
                    $linkItem->save();
                }

                return redirect('/admin/'.$page->slug.'/links');
            }
        }
        return redirect('/admin');
    }

    public function delLink($slug, $linkid)
    {
        $user = Auth::user();
        $page = Page::where('id_user', $user->id)
            ->where('slug', $slug)
            ->first();
        if($page) {
            $link = Link::where('id_page', $page->id)
                ->where('id', $linkid)
                ->first();
            if($link) {
                $link->delete();
                //Corrigindo as posições
                $allLinks = Link::where('id_page', $page->id)
                    ->orderBy('order', 'ASC')
                    ->get();
                foreach($allLinks as $linkKey => $linkItem) {
                    $linkItem->order = $linkKey;
                    $linkItem->save();
                }
                return redirect('/admin/'.$page->slug.'/links');
            }
        }
        return redirect('/admin');
    }

    public function pageDesign($slug)
    {
        $user = Auth::user();
        $page = Page::where('slug', $slug)
            ->where('id_user', $user->id)
            ->first();
        if($page) {
            $page->op_bg_value = explode(",", $page->op_bg_value);
            return view('admin/page_design', [
                'menu' => 'design',
                'page' => $page
            ]);
        } else {
            return redirect('/admin');
        }
    }

    public function editDesignAction($slug, Request $request)
    {
        $user = Auth::user();
        $page = Page::where('slug', $slug)
            ->where('id_user', $user->id)
            ->first();
        if($page) {
            $fields = $request->validate([
                'op_title' => ['required', 'min:2'],
                'op_description' => ['required', 'min:10'],
                'slug' => ['required', 'min:2'],
                'op_profile_image' => ['image','mimes:jpeg,jpg,png,gif'],
                'op_bg_value1' => ['required', 'regex:/^[#][0-9A-F]{3,6}$/i'],
                'op_bg_value2' => ['required', 'regex:/^[#][0-9A-F]{3,6}$/i'],
                'op_font_color' => ['required', 'regex:/^[#][0-9A-F]{3,6}$/i']
            ]);

            if(!empty($fields['op_profile_image'])) {
                $ext = $fields['op_profile_image']->extension();
                $imageName = time() . '.' . $ext;
                $fields['op_profile_image']->move(public_path('media/uploads'), $imageName);
                $page->op_profile_image = $imageName;
            }

            $page->op_title = $fields['op_title'];
            $page->op_description = $fields['op_description'];
            $page->slug = $fields['slug'];
            $page->op_bg_value = $fields['op_bg_value1'].','.$fields['op_bg_value2'];
            $page->op_font_color = $fields['op_font_color'];
            $page->save();

            return redirect('/admin/'.$page->slug.'/design');
        } else {
            return redirect('/admin');
        }
    }

    public function pageStats($slug)
    {
        $user = Auth::user();
        $page = Page::where('slug', $slug)
            ->where('id_user', $user->id)
            ->first();
        if($page) {
            $views = View::where('id_page', $page->id)
                ->where('view_date','>',date('Y-m-d H:i:s', strtotime('-30 days')))
                ->orderBy('view_date', 'DESC')
                ->get();
        }
        foreach($views as $view) {
            $date[] = date('d/m/y',strtotime($view->view_date));
            $qtde[] = $view->total;
        }
        $date = json_encode($date);
        $qtde = json_encode($qtde);
        return view('admin/page_stats', [
            'menu' => 'stats',
            'page' => $page,
            'views' => $views,
            'date' => $date,
            'qtde' => $qtde
        ]);
    }

    public function editUser()
    {
        $user = Auth::user();
        return view('admin/user', [
            'user' => $user
        ]);
    }

    public function editUserAction(Request $request)
    {
        $user = Auth::user();
        $data = $request->only([
            'name',
            'email',
            'password',
            'password_confirmation'
        ]);
        $validator = Validator::make([
            'name' => $data['name'],
            'email' => $data['email']
        ], [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100']
        ]);
        $user->name = $data['name'];
        if($user->email != $data['email']) {
            $hasEmail = User::where('email', $data['email'])->get();
            if(count($hasEmail) === 0) {
                $user->email = $data['email'];
            } else {
                $validator->errors()->add('email', __('validation.unique', [
                    'attribute' => 'email'
                ]));
            }
        }
        if($user->password != $data['password']) {
            if (strlen($data['password']) >= 4) {
                if ($data['password'] === $data['password_confirmation']) {
                    $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
                } else {
                    $validator->errors()->add('password', __('validation.confirmed', [
                        'attribute' => 'password',
                    ]));
                }
            } else {
                $validator->errors()->add('password', __('validation.min.string', [
                    'attribute' => 'password',
                    'min' => 4
                ]));
            }
        }
        if(count($validator->errors()) > 0) {
            return redirect()->route('user')
                ->withErrors($validator)
                ->withInput();
        }
        $user->save();
        return redirect()->route('user')
            ->with('warning', 'Informações alteradas com sucesso!');

    }

}
