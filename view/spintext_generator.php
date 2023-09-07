<?php
/* if (!isset($data['token']) || $data['token'] === NULL || !is_string($data['token'])) {
    exit;
} */
?>
<?php if ($_viewFileSection == 'responseheader') { ?>


<?php } else if ($_viewFileSection == 'head') { ?>

	<link rel="canonical" href="https://grosen.tools/spintext-generator" />
	<link rel="alternate" hreflang="en" href="https://grosen.tools/spintext-generator" />
	<link rel="alternate" hreflang="x-default" href="https://grosen.tools/spintext-generator" />
	<link rel="stylesheet" type="text/css" href="/plugin/LizardTools/css/spintext_generator.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css" />

	<meta property="og:type" content="website" />
	<meta property="og:url" content="https://grosen.tools/spintext-generator" />
	<meta property="og:title" content="<?= $viewTitle ?>" />
	<meta property="og:description" content="<?= $viewMetaDescription; ?>" />
	<!-- meta property="og:image:url" content="https://grosen.tools/plugin/LizardTools/img/password.png"/ -->
	<!-- meta property="og:image:secure_url" content="https://grosen.tools/plugin/LizardTools/img/password.png"/ -->
	<meta property="og:image:type" content="image/png"/>
	<meta property="og:image:width" content="1920"/>
	<meta property="og:image:height" content="907"/>
	<meta property="og:image:alt" content="<?= $viewTitle ?>"/>
	<meta property="og:locale" content="en" />
	<meta name="twitter:card" content="summary" />
	<meta name="twitter:title" content="<?= $viewTitle ?>" />
	<meta name="twitter:description" content="<?= $viewMetaDescription; ?>" />
	<!-- meta name="twitter:image" content="https://grosen.tools/plugin/LizardTools/img/password.png" -->

	<script type="application/javascript" src="/js/common.js"></script>

	<script type="module">
		import {setHttpHost, generateFiles, generateSpinText } from '/plugin/LizardTools/js/lizard_tools.js';
		setHttpHost('https://<?= $_SERVER['HTTP_HOST']; ?>');

		let elements = [];
		elements['errorMessageElement'] = document.getElementById('errorMessage');
		elements['spintaxElement'] = document.getElementById('spintax');
		elements['filesCountElement'] = document.getElementById('filesCount');
		elements['spinTextElement'] = document.getElementById('spinText');
		elements['coloredSpintaxElement'] = document.getElementById('coloredSpintax');
		elements['downloadLinksElement'] = document.getElementById('downloadLinks');

		document.getElementById('generateTextFilesButton').addEventListener('click', (e) => { generateFiles(e.target, elements); });
		document.getElementById('generateCsvFilesButton').addEventListener('click', (e) => { generateFiles(e.target, elements); });
		document.getElementById('spinButton').addEventListener('click', (e) => { generateSpinText(e.target, elements); });

	</script>



<?php } else if ($_viewFileSection == 'body') { ?>

	<div class="container is-max-desktop">
		<div class="notification has-background-white content">

			<p>&lt;&lt;&nbsp;<a href="/">home</a></p>
			<a href="/spintext-generator"><h1>Spintext generator</h1></a>

			<p>Spintax example: <span style="font-family: monospace;">{Hi|Hello|Good day}</span> This will result in one of the greetings to be randomly selected. Beware spintax can reside inside spintax e.g. <span style="font-family: monospace;">{Hi|Hello|Good {day|evening|night}}</span>.</p>
			<p>If you have suggestions to improve this tool, send me an email to <a href="mailto:grosen@grosen.tools">grosen@grosen.tools</a></p>

            <p><em>You can now use this tool via <strong>an API</strong></em> => <a href="/">see documentation here</a></p>

			<input type="hidden" name="zipFilePath" value="" />
			<table>
				<tr>
					<td>
                        <textarea name="spintax" id="spintax" style="min-width: 300px; min-height: 100px;" ><?php echo $spintax_s; ?></textarea> <span>&lt;== <strong>Resize</strong> text-editor here</span>
					</td>
				</tr>
				<tr>
					<td>
						<select name="filesCount" id="filesCount" class="select is-normal is-rounded">
							<option value="1">1</option>
<?php
	for ($i = 5; $i <= 2000; $i += 5) {
?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
<?php
	}

	for ($i = 10000; $i <= 1000000; $i += 10000)
	{
?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
<?php
	}
?>
						</select>

						<button name="generateTextFilesButton" id="generateTextFilesButton" class="button is-dark">ZIP &amp; DOWNLOAD FILES &gt;&gt;</button>
						<button name="generateCsvFilesButton" id="generateCsvFilesButton" class="button is-dark">ZIP &amp; DOWNLOAD CSV FILE &gt;&gt;</button>
						<button name="spinButton" id="spinButton" class="button is-dark">SPIN &gt;&gt;</button>
					</td>
				</tr>
			</table>

			<hr class="clear" />
			<h2>Spintax validation:</h2>
			<div id="errorMessage"></div>

			<hr class="clear" />
			<h2>Spinner Text:</h2>
			<div id="spinText" style="font-family: monospace; font-size: 10px; width: 500px;"></div>

			<hr class="clear" />
			<h2>Colored spintax</h2>
			<div style="font-family: monospace; font-size: 10px; width: 500px; overflow-x: auto;" id="coloredSpintax"></div>

			<div id="downloadLinks"></div>
		</div>
        <div style="text-align: right;"><em>No user data are tracked on this website</em></div>
	</div>

<?php } else if ($_viewFileSection == 'footer') { ?>



<?php } ?>