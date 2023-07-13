<?php

class Kodecamps {
	private static $initiated = false;
	public static function init() {
		if ( ! self::$initiated ) {
			self::init_hooks();
		}
	}

	/**
	 * Initializes WordPress hooks
	 */
	private static function init_hooks() {
		self::$initiated = true;
		add_shortcode('xlab', 'Kodecamps::show_xlab_form');
		add_action( 'wp_enqueue_scripts','Kodecamps::enqueue_scripts'  );
	}

	static function enqueue_scripts() {
		wp_enqueue_script('ace', KODECAMPS_URL. '/asset/js/ace.js' ,  array( 'jquery' ), '1.0.0');
		wp_enqueue_script('texteditor', KODECAMPS_URL. '/asset/js/texteditor.js' ,  array( 'jquery' ), '1.0.0');
		wp_enqueue_script('xlabjs', KODECAMPS_URL. '/asset/js/main.js' ,  array( 'jquery' ), '1.0.0');
		wp_enqueue_style( 'xlabcss', KODECAMPS_URL.'/asset/css/style.css', array(), '1.0.0' );

	}

    static function show_xlab_form($atts) {
		$default = array(
			'link' => '#',
		);
		$a = shortcode_atts($default, $atts);
		 ?>
        <link
                rel="stylesheet"
                href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
                integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
                crossorigin="anonymous"
        />

        <style type="text/css" media="screen">
            body {
                overflow: hidden;
            }

            #editor {
                min-width: 500px;
                min-height: 500px;
            }
        </style>
		<div>
			<h1>Code Editor</h1>
			<select id="myselect" onchange="onSelectChange(this.value.trim())">
				<option value="53" >C++</option>
				<option value="62" >Java</option>
				<option value="70">Python</option>
			</select>
			<div id="editorContainer">
				<div class="container" style="margin-top: 30px">
					<div class="row">
						<div class="col">
              <pre id="editor">
      </pre
      >
						</div>
						<div class="col">
							<button class="btn btn-success">Execute</button>
							<br />
							<pre id="ans"></pre>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script>
            // document.onload()

            function onSelectChange(selectedVal){

                console.log(selectedVal)
                if(selectedVal != undefined && selectedVal!=null && selectedVal!=""){
                    $("button").off('click');
                    codeEditor(selectedVal)
                }
            }
            window.onload = function () {
                codeEditor("53");
            };
		</script>
<?php
	}
}