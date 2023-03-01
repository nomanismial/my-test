<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class SitemapController extends Controller
{

    private $links = array();
    private $home  = "";

    public function __construct()
    {
        $this->home = route("HomeUrl") . "/";
    }

    public function _commonLinks()
    {

        $b = ["url" => $this->home . "ask-me",
            "priority"  => "0.7",
            "frequency" => "Daily"];
        $c = ["url" => $this->home . "privacy-policy",
            "priority"  => "0.5",
            "frequency" => "Daily"];
        $d = [
            "url"       => $this->home . "terms-conditions",
            "priority"  => "0.5",
            "frequency" => "Daily",
        ];
        $e = [
            "url"       => $this->home . "about",
            "priority"  => "0.5",
            "frequency" => "Daily",
        ];
        $f = [
            "url"       => $this->home . "write-for-us",
            "priority"  => "0.5",
            "frequency" => "Daily",
        ];

        $a = [
            "url"       => $this->home . "faqs",
            "priority"  => "0.5",
            "frequency" => "Daily",
        ];
        $this->links[] = $b;
        $this->links[] = $c;
        $this->links[] = $d;
        $this->links[] = $a;
        $this->links[] = $e;
        $this->links[] = $f;
    }

    public function _blogLinks()
    {
        $r = DB::table("blogs")->where('status', 'publish')->get();
        foreach ($r as $k => $v) {
            $link = $v->slug;
            $link .= "-2" . $v->id;
            $lk = array(
                "url" => $this->home . $link, "priority" => "0.8", "frequency" => "Daily",
            );
            $this->links[] = $lk;
        }
    }
    public function _blogimages()
    {
        $r  = DB::table("blogs")->where('status', 'publish')->get();
        $lk = array();
        foreach ($r as $k => $v) {
            $link = $v->slug;
            $img  = $v->cover;
            $link .= "-2" . $v->id;
            //dd($link);
            $htmlString = file_get_contents($this->home . $link);
            $htmlDom    = new \DOMDocument;
            @$htmlDom->loadHTML($htmlString);
            $imageTags       = $htmlDom->getElementsByTagName('img');
            $extractedImages = array();
            foreach ($imageTags as $imageTag) {
                $imgSrc            = $imageTag->getAttribute('src');
                $altText           = $imageTag->getAttribute('alt');
                $titleText         = $imageTag->getAttribute('title');
                $extractedImages[] = array(
                    'src'   => $imgSrc,
                    'alt'   => $altText,
                    'title' => $titleText,
                );
            }

            $lk[] = array(
                "url" => $this->home . $link, "images" => $extractedImages, "priority" => "0.5", "frequency" => "Daily",
            );
        }

        $this->links[] = $lk;
        //dd($this->links);
    }
    public function _blogcatsLinks()
    {

        $r             = DB::table("blog_categories")->get();
        $this->links[] = [
            "url"       => $this->home,
            "priority"  => "1.0",
            "frequency" => "Daily",
        ];
        foreach ($r as $k => $v) {
            $link = $v->slug;
            $link .= "-1" . $v->id;
            $lk = array(
                "url" => $this->home . $link, "priority" => "0.8", "frequency" => "Daily",
            );
            $this->links[] = $lk;
        }
    }

    public function _getLinks()
    {
        $this->_blogcatsLinks();
        $this->_blogLinks();
        $this->_commonLinks();
    }

    public function _show()
    {
        $this->_getLinks();
        header('Content-Type: text/xml');
        echo '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="' . $this->home . 'assets/sitemap.xsl"?>';
        echo "\n";
        echo '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        echo "\n";
        foreach ($this->links as $link) {
            echo "\t<url>\n";
            echo "\t\t<loc>" . htmlentities($link['url']) . "</loc>\n";
            //echo "\t\t<lastmod>{$link['lastmod']}</lastmod>\n";
            echo "\t\t<changefreq>{$link['frequency']}</changefreq>\n";
            echo "\t\t<priority>{$link['priority']}</priority>\n";
            echo "\t</url>\n";
        }
        echo '</urlset>';
        exit;
    }
    public function _showimages()
    {
        $this->_blogimages();
        //dd($this->links);
        header('Content-Type: text/xml');
        echo '<?xml version="1.0" encoding="UTF-8"?>';
        echo "\n";
        echo '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9">';
        echo "\n";
        foreach ($this->links[0] as $k => $link) {
            echo "\t<url>\n";
            echo "\t\t<loc>" . htmlentities($link['url']) . "</loc>\n";
            foreach ($link['images'] as $key => $v) {
                echo "\t\t<image:image> \n ";
                echo "\t\t<image:loc>" . $v['src'] . "</image:loc>\n";
                if ($v['title'] != "") {
                    echo "\t\t<image:title>" . $v['title'] . "</image:title>\n";
                }if ($v['title'] != "") {
                    echo "\t\t<image:caption>" . $v['alt'] . "</image:caption>\n";
                }
                echo "\t\t</image:image>\n";
            }
            //echo "\t\t<lastmod>{$link['lastmod']}</lastmod>\n";
            echo "\t\t<changefreq>{$link['frequency']}</changefreq>\n";
            echo "\t\t<priority>{$link['priority']}</priority>\n";
            echo "\t</url>\n";
        }
        echo '</urlset>';
        exit;
    }

}
