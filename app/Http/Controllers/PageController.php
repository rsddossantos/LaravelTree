<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Link;
use App\Models\View;

class PageController extends Controller
{
    public function index($slug) {
        $page = Page::where('slug', $slug)->first();
        if($page) {
            // Background color or picture
            $bg = '#FFFFFF';
            switch($page->op_bg_type) {
                case 'image':
                    $bg = "url('".url('/media/uploads')."/".$page->op_bg_value."')";
                break;
                case 'color':
                    $colors = explode (',', $page->op_bg_value);
                    $bg_temp = 'linear-gradient(90deg,';
                    $bg_temp .= $colors[0].',';
                    $bg_temp .= $colors[1] ?? $bg;
                    $bg_temp .= ')';
                    $bg = $bg_temp;
                break;
            }



            // Links
            $links = Link::where('id_page', $page->id)
                ->where('status', 1)
                ->orderBy('order')
                ->get();


            // Registrar a visualização
            $view = View::firstOrNew(
                ['id_page' => $page->id, 'view_date' => date('Y-m-d')]
            );
            $view->total++;
            $view->save();


            return view('page', [
                'font_color'=> $page->op_font_color,
                'profile_image' => url('media/uploads').'/'.$page->op_profile_image,
                'title' => $page->op_title,
                'description' => $page->op_description,
                'fb_pixel' => $page->op_fb_pixel,
                'bg' => $bg,
                'links' => $links

            ]);
        } else {
            return view('notfound');
        }
    }
}
