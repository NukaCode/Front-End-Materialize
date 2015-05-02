<?php namespace NukaCode\Materialize\Html;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Contracts\View\Factory;
use NukaCode\Html\FormBuilder as BaseFormBuilder;

class FormBuilder extends BaseFormBuilder
{
    protected $requiredClasses = [];

    private   $view;

    public function __construct(HtmlBuilder $html, UrlGenerator $url, $csrfToken, Factory $view)
    {
        $this->url       = $url;
        $this->html      = $html;
        $this->csrfToken = $csrfToken;
        $this->view      = $view;
    }

    public function groupOpen($size = 12)
    {
        return '<div class="input-field col s' . $size . '">';
    }

    public function groupClose()
    {
        return '</div>';
    }

    public function label($name, $value = null, $options = [])
    {
        return parent::label($name, $value, $options);
    }

    public function hidden($name, $value = null, $options = [])
    {
        // Set up the attributes
        $options = $this->verifyAttributes('text', $options);

        return parent::hidden($name, $value, $options);
    }

    public function icon($class, $options = [])
    {
        $options = $this->verifyHasOption($options, 'class', 'prefix');
        $options = $this->verifyHasOption($options, 'class', $class);

        return $this->html->icon(null, $options);
    }

    public function date($name, $value = null, $options = [], $label = null)
    {
        // Set up the attributes
        $options = $this->verifyHasOption($options, 'class', 'datepicker');
        $options = $this->verifyAttributes('date', $options);

        $this->setDateRequirements();

        // Create the default input
        $input = $this->input('date', $name, $value, $options);

        return $this->createOutput($name, $label, $input);
    }

    protected function setDateRequirements()
    {
        static $exists = false;
        if (! $exists) {
            $this->addToSection('onReadyJs', '
$(\'.datepicker\').pickadate({
    selectMonths: true,
    selectYears: 15
});
			'
            );
            $exists = true;
        }
    }

    public function text($name, $value = null, $options = [], $label = null)
    {
        // Set up the attributes
        $options = $this->verifyAttributes('text', $options);

        // Create the default input
        $input = parent::text($name, $value, $options);

        return $this->createOutput($name, $label, $input);
    }

    public function textarea($name, $value = null, $options = [], $label = null)
    {
        // Set up the attributes
        $options = $this->verifyAttributes('textarea', $options);
        $options = $this->verifyHasOption($options, 'class', 'materialize-textarea');

        // Create the default input
        $input = parent::textarea($name, $value, $options);

        return $this->createOutput($name, $label, $input);
    }

    public function email($name, $value = null, $options = [], $label = null)
    {
        // Set up the attributes
        $options = $this->verifyAttributes('email', $options);

        // Create the default input
        $input = parent::email($name, $value, $options);

        return $this->createOutput($name, $label, $input);
    }

    public function password($name, $options = [], $label = null)
    {
        // Set up the attributes
        $options = $this->verifyAttributes('password', $options);

        // Create the default input
        $input = parent::password($name, $options);

        return $this->createOutput($name, $label, $input);
    }

    public function select($name, $list = [], $selected = null, $options = [], $label = null)
    {
        $this->setSelectRequirements();

        // Create the default input
        $input = parent::select($name, $list, $selected, $options);

        return $this->createOutput($name, $label, $input);
    }

    protected function setSelectRequirements()
    {
        static $exists = false;
        if (! $exists) {
            $this->addToSection('onReadyJs', '
$(\'select\').material_select();
			'
            );
            $exists = true;
        }
    }

    protected function createOutput($name, $label, $input)
    {
        // Set up the label
        $label = $label != null ? $this->label($name, $label) : null;

        $this->requiredClasses = [];

        return <<<HTML
			$input
			$label
HTML;
    }

    protected function createSelectable($type, $name, $value, $checked, $options, $label, $inline)
    {
        // Set up the label
        $label = $label != null ? $this->label($name, $label) : null;

        return '
		<p>' .
               parent::$type($name, $value, $checked, $options) .
               $label . '
		</p>
		';
    }

    public function checkbox($name, $value = null, $checked = false, $options = [], $label = null, $inline = false)
    {
        return $this->createSelectable('checkbox', $name, $value, $checked, $options, $label, $inline);
    }

    public function radio($name, $value = null, $checked = false, $options = [], $label = null, $inline = false)
    {
        return $this->createSelectable('radio', $name, $value, $checked, $options, $label, $inline);
    }

    public function verifyAttributes($input, $options)
    {
        // All inputs
        $options = $this->verifyHasOption($options, 'class', 'validate');

        if (! empty($this->requiredClasses)) {
            foreach ($this->requiredClasses as $class) {
                $options = $this->verifyHasOption($options, 'class', $class);
            }
        }

        return $options;
    }
}
