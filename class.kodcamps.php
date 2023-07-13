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
		add_shortcode('xlab_aws', 'Kodecamps::show_xlab_form_aws');

		add_action( 'wp_enqueue_scripts','Kodecamps::enqueue_scripts'  );

		add_action( 'wp_head', 'Kodecamps::insecure_header_metadata' );
		add_action('wp_ajax_aws_emulator', 'Kodecamps::aws_emulator');
		add_action('wp_ajax_nopriv_aws_emulator','Kodecamps:: aws_emulator');

	}

    static function aws_emulator() {
      $out = <<<EOF
{
    "OwnerId": "123456789012",
    "ReservationId": "r-5875ca20",
    "Groups": [
        {
            "GroupName": "my-sg",
            "GroupId": "sg-903004f8"
        }
    ],
    "Instances": [
        {
            "Monitoring": {
                "State": "disabled"
            },
            "PublicDnsName": null,
            "Platform": "windows",
            "State": {
                "Code": 0,
                "Name": "pending"
            },
            "EbsOptimized": false,
            "LaunchTime": "2013-07-19T02:42:39.000Z",
            "PrivateIpAddress": "10.0.1.114",
            "ProductCodes": [],
            "VpcId": "vpc-1a2b3c4d",
            "InstanceId": "i-5203422c",
            "ImageId": "ami-173d747e",
            "PrivateDnsName": "ip-10-0-1-114.ec2.internal",
            "KeyName": "MyKeyPair",
            "SecurityGroups": [
                {
                    "GroupName": "my-sg",
                    "GroupId": "sg-903004f8"
                }
            ],
            "ClientToken": null,
            "SubnetId": "subnet-6e7f829e",
            "InstanceType": "t2.micro",
            "NetworkInterfaces": [
                {
                    "Status": "in-use",
                    "SourceDestCheck": true,
                    "VpcId": "vpc-1a2b3c4d",
                    "Description": "Primary network interface",
                    "NetworkInterfaceId": "eni-a7edb1c9",
                    "PrivateIpAddresses": [
                        {
                            "PrivateDnsName": "ip-10-0-1-114.ec2.internal",
                            "Primary": true,
                            "PrivateIpAddress": "10.0.1.114"
                        }
                    ],
                    "PrivateDnsName": "ip-10-0-1-114.ec2.internal",
                    "Attachment": {
                        "Status": "attached",
                        "DeviceIndex": 0,
                        "DeleteOnTermination": true,
                        "AttachmentId": "eni-attach-52193138",
                        "AttachTime": "2013-07-19T02:42:39.000Z"
                    },
                    "Groups": [
                        {
                            "GroupName": "my-sg",
                            "GroupId": "sg-903004f8"
                        }
                    ],
                    "SubnetId": "subnet-6e7f829e",
                    "OwnerId": "123456789012",
                    "PrivateIpAddress": "10.0.1.114"
                }              
            ],
            "SourceDestCheck": true,
            "Placement": {
                "Tenancy": "default",
                "GroupName": null,
                "AvailabilityZone": "us-west-2b"
            },
            "Hypervisor": "xen",
            "BlockDeviceMappings": [
                {
                    "DeviceName": "/dev/sda1",
                    "Ebs": {
                        "Status": "attached",
                        "DeleteOnTermination": true,
                        "VolumeId": "vol-877166c8",
                        "AttachTime": "2013-07-19T02:42:39.000Z"
                    }
                }              
            ],
            "Architecture": "x86_64",
            "StateReason": {
                "Message": "pending",
                "Code": "pending"
            },
            "RootDeviceName": "/dev/sda1",
            "VirtualizationType": "hvm",
            "RootDeviceType": "ebs",
            "Tags": [
                {
                    "Value": "MyInstance",
                    "Key": "Name"
                }
            ],
            "AmiLaunchIndex": 0
        }
    ]
}
EOF;
echo $out;
    }

    static function insecure_header_etadata() {
        ?>
	    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" data-id="emu" admin-url = "<?php echo admin_url( 'admin-ajax.php' ) ?>" />
        <?php

    }
	static function enqueue_scripts() {
		wp_enqueue_script('ace', KODECAMPS_URL. '/asset/js/ace.js' ,  array( 'jquery' ), '1.0.0');
		wp_enqueue_script('texteditor', KODECAMPS_URL. '/asset/js/texteditor.js' ,  array( 'jquery' ), '1.0.0');
		//wp_enqueue_script('texteditor', KODECAMPS_URL. '/asset/js/texteditor.js' ,  array( 'jquery' ), '1.0.0');
		wp_enqueue_script('xlabjs', KODECAMPS_URL. '/asset/js/main.js' ,  array( 'jquery' ), '1.0.0');
		wp_enqueue_style( 'xlabcss', KODECAMPS_URL.'/asset/css/style.css', array(), '1.0.0' );

	}

    static function show_xlab_form_aws($atts) {
	    $default = array(
		    'command' => 'ec2',
	    );
	    $a = shortcode_atts($default, $atts);
        ?>
         <link
                rel="stylesheet"
                href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
                integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
                crossorigin="anonymous"
        />
        <script type="text/javascript" src="<?php echo KODECAMPS_URL ?>/asset/js/aws_editor.js"></script>

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
			<h1>AWS CLI Simulator</h1>
            <div id="editorContainer">
                <div class="container" style="margin-top: 30px">
                    <div class="row">
                        <div class="col">
              <pre id="aws_editor">
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
            <?php
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