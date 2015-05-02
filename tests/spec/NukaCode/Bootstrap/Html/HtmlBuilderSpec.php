<?php namespace spec\NukaCode\Materialize\Html;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Illuminate\Routing\UrlGenerator;

class HtmlBuilderSpec extends ObjectBehavior {

    function it_is_initializable()
    {
        $this->shouldHaveType('NukaCode\Materialize\Html\HtmlBuilder');
    }

    function it_creates_image_links(UrlGenerator $url)
    {
        $url->to('/', null)->shouldBeCalled()->willReturn('localhost');
        $this->beConstructedWith($url);

        $html = '<a href="localhost"><img src="http://placehold.it/100x100.png" /></a>';

        $this->linkImage('/', '<img src="http://placehold.it/100x100.png" />')->shouldReturn($html);
    }
}
