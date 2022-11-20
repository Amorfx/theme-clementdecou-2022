<?php

namespace Theme2022\Admin\Fields;

class TokenGenerationField extends \acf_field {
    public function __construct() {
        $this->name = 'token_generator_field';
        $this->label = 'Générateur de token API';
        $this->category = 'basic';
        parent::__construct();
    }

    public function render_field( $field ) {
?>
        <button class="button button-primary" id="js-generate-token">Générer un token api</button>
        <input id="js-token" style="display: inline-block; margin-left: 20px; width: 300px;" type="text" />
        <script type="application/javascript">
            jQuery('#js-generate-token').on('click', function(e) {
              e.preventDefault();
              jQuery.get(ajaxurl, {
                'action': 'generateApiToken'
              }, function(data) {
                var jsToken = document.querySelector('#js-token');
                jsToken.value = data.token;
                jsToken.select();
                document.execCommand('copy');
              }, 'json');
            });
        </script>
<?php
    }
}
