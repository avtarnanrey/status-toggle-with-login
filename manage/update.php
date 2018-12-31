<?php

include("./configs/_config.php");

?>





<!DOCTYPE html>

<html lang="en">

	<head>

		<meta charset="utf-8">

		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

		<meta name="description" content="">

		<meta name="author" content="">

		<meta name="robots" content="noindex,nofollow"/>



		<title>BRRC Port Status - Report a Problem</title>
		<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
        crossorigin="anonymous">

	</head>



	<body>



	<?php

$portId = isset($_GET['port_id']) && is_numeric($_GET['port_id']) && $_GET['port_id'] > 0 && $_GET['port_id'] < 12 ? $_GET['port_id'] : null;



	//If someone is fucking with us, get out of here

if ($portId === null) redirect('/index.php');



?>

	<div class="container">



		<h3>Report a problem with Port <?php echo $portId; ?></h3>

		<hr />

		<form method="post" action="/ports/report_submit.php">

			<div class="form-group">

				<label for="name">Name</label>

				<input type="text" class="form-control" id="name" name="name" placeholder="Your name here">

			</div>

			<div class="form-group">

				<label for="description">Describe the problem</label>

				<textarea class="form-control" id="description" name="description" placeholder="Describe the issue here" rows="6"></textarea>

				<p class="help-block">Enter as full a description of the problem as you wish</p>

			</div>

			<div class="form-group">

				<label for="description">Is the port broken? </label>

				<div class="radio">

					<label class="radio-inline">

						<input type="radio" name="port_down" id="port_down_yes" value="1" checked> Yes

					</label>

					<label class="radio-inline">

						<input type="radio" name="port_down" id="port_down_yes" value="0"> No

					</label>

				</div>

			</div>



			<hr />

			<button type="submit" class="btn btn-default">Submit</button>



			<input type="hidden" name="port_id" value="<?php echo $portId; ?>" />

		</form>

	</div>

	</body>

</html>



<?php

function redirect($uri = '', $method = 'auto', $code = null)

{

	// IIS environment likely? Use 'refresh' for better compatibility

    if ($method === 'auto' && isset($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS') !== false) {

        $method = 'refresh';

    } elseif ($method !== 'refresh' && (empty($code) or !is_numeric($code))) {

        if (isset($_SERVER['SERVER_PROTOCOL'], $_SERVER['REQUEST_METHOD']) && $_SERVER['SERVER_PROTOCOL'] === 'HTTP/1.1') {

            $code = ($_SERVER['REQUEST_METHOD'] !== 'GET')

                ? 303	// reference: http://en.wikipedia.org/wiki/Post/Redirect/Get

            : 307;

        } else {

            $code = 302;

        }

    }



    switch ($method) {

        case 'refresh':

            header('Refresh:0;url=' . $uri);

            break;

        default:

            header('Location: ' . $uri, true, $code);

            break;

    }

    exit;

}



?>





<?php

$mysqli->close();

?>