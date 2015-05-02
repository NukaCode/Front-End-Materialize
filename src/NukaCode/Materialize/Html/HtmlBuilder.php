<?php namespace NukaCode\Materialize\Html;

use NukaCode\Html\HtmlBuilder as BaseHtmlBuilder;

class HtmlBuilder extends BaseHtmlBuilder {

	public function flow($text)
	{
		return '<p class="flow-text">'. $text .'</p>';
	}

	public function shadow($text, $depth)
	{
		return '<p class="z-depth-'. $depth .'">'. $text .'</p>';
	}

    public function progress($percentage = null)
    {
        $class = $percentage == null ?  'indeterminate' : 'determinate';

        return '
            <div class="progress">
                <div class="'. $class .'" style="width: '. $percentage .'%"></div>
            </div>
        ';
    }

    public function preloader($color = null, $size = null)
    {

        if ($color == null) {
            return '
                <div class="preloader-wrapper '. $size .' active">
                    <div class="spinner-layer spinner-blue">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="gap-patch">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>

                    <div class="spinner-layer spinner-red">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="gap-patch">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>

                    <div class="spinner-layer spinner-yellow">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="gap-patch">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>

                    <div class="spinner-layer spinner-green">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="gap-patch">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
            ';
        } else {
            return '
            <div class="preloader-wrapper ' . $size . ' active">
                <div class="spinner-layer spinner-' . $color . '-only">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
        ';
        }
    }

    public function embed($url)
    {
        return '
            <div class="video-container">
                <iframe src="' . $url . '" frameborder="0" allowfullscreen></iframe>
            </div>';
    }
}