<?php

namespace Mj\Breadcrumb;

use Illuminate\Config\Repository;
use Config;

class Breadcrumb
{
    /*
    | A small breadcrumb class. The class can be edited to your use your own
    | style-classes.
    */

    /**
     * Illuminate config repository.
     *
     * @var Illuminate\Config\Repository
     */
    protected $config;

    private $seperator;
    private $breadcrumb = array();

    /**
     * Create a new profiler instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->config = Config::get('Breadcrumb::config');

        $this->seperator = ($this->config['enable_seperator'] === true)
                            ? '<span class="divider">'.$this->config['default_seperator'].'</span>'
                            : '';
    }

    public function generate($ucfirst = true)
    {
        $output = '';
        $count  = 1;

        $output .= '<div itemscope itemtype="http://schema.org/WebPage">';
        $output .= '<ol class="breadcrumb" itemprop="breadcrumb">';
        foreach ($this->breadcrumbs as $key => $value) {
            
            if ($count != count($this->breadcrumbs)) {
                $output .= '<li><a href="' . $value . '">' . ($ucfirst? ucfirst($key) : $key) . '</a>';
            } else {
                $output .= '<li class="active">' . ($ucfirst? ucfirst($key) : $key) . '</li>';
            }

            if ($count != count($this->breadcrumbs)) {
                $output .= ' ' . $this->seperator . '</li>';
            }

            $count++;
        }
        $output .= '</ol>';
        $output .= '</div>';
        $output .= '<div class="clearfix"></div>';

        return $output;
    }
    
    public function addBreadcrumb($title, $uri = null)
    {
        $this->breadcrumbs[$title] = $uri;

        return $this;
    }

    public function setSeperator($seperator)
    {
        $this->seperator = $seperator;

        return $this;
    }
}
