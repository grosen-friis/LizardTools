<?php
/* if (!isset($data['token']) || $data['token'] === NULL || !is_string($data['token'])) {
    exit;
} */
?>
<?php if ($_viewFileSection == 'responseheader') { ?>


<?php } else if ($_viewFileSection == 'head') { ?>

    <link rel="canonical" href="https://grosen.tools/transfer" />
    <link rel="alternate" hreflang="en" href="https://grosen.tools/transfer" />
    <link rel="alternate" hreflang="x-default" href="https://grosen.tools/transfer" />
    <link rel="stylesheet" type="text/css" href="/plugin/LizardTools/css/transfer.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css" />

    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://grosen.tools/transfer" />
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
        import {setHttpHost, handleTransferUpload, copyDownloadLinkToClipBoard, sendLinkInEmail } from '/plugin/LizardTools/js/lizard_tools.js';
        setHttpHost('https://<?= $_SERVER['HTTP_HOST']; ?>');

        let elements = [];
        elements['errorMessageElement'] = document.getElementById('errorMessage');

        /* let transferUploadFormElement = document.getElementById('transferUploadForm');
        elements['transferUploadFormElement'] = transferUploadFormElement;
        transferUploadFormElement.addEventListener('submit', handleTransferUpload); */

        const fileInputElement = document.querySelector('#uploadFileJs input[type=file]');
        const fileNameElement = document.querySelector('#uploadFileJs .file-name');
        fileInputElement.onchange = () => {
            if (fileInputElement.files.length > 0) {
                fileNameElement.textContent = fileInputElement.files[0].name;
            }
        }
        elements['fileNameElement'] = fileNameElement;

        let uploadButtonElement = document.getElementById('uploadButton');
        uploadButtonElement.addEventListener('click', (e) => { handleTransferUpload(e.target, elements, '<?= $fileExtensionsAllowedJson; ?>'); });
        elements['uploadButtonElement'] = uploadButtonElement;
        elements['uploadStatusProgressElement'] = document.getElementById('uploadStatusProgress');
        elements['uploadStatusProgress2Element'] = document.getElementById('uploadStatusProgress2');
        elements['uploadStatusElement'] = document.getElementById('uploadStatus');
        elements['chooseFileLabelElement'] = document.getElementById('chooseFileLabel');
        elements['transferUploadFormElement'] = document.getElementById('transferUploadForm');
        elements['uploadErrorMessageElement'] = document.getElementById('uploadErrorMessage');
        elements['uploadFileResultElement'] = document.getElementById('uploadFileResult');
        elements['uploadFileLinkElement'] = document.getElementById('uploadFileLink');

        document.getElementById('copyToClipBoardButton').addEventListener('click', (e) => { copyDownloadLinkToClipBoard(e.target, elements); });
        document.getElementById('sendLinkInEmailButton').addEventListener('click', (e) => { sendLinkInEmail(e.target, elements); });



    </script>


<?php } else if ($_viewFileSection == 'body') { ?>

    <div class="container is-max-desktop">
        <div class="notification has-background-white content">

            <p>&lt;&lt;&nbsp;<a href="/">home</a></p>
            <a href="/transfers"><h1>Transfer large file tool</h1></a>

            <div id="uploadFileJs" class="file has-name is-dark">
                <label class="file-label" id="chooseFileLabel">
                    <form id="transferUploadForm">
                        <input class="file-input" type="file" name="resume" id="file" />
                    </form>
                    <span class="file-cta">
                        <span class="file-icon">
                            <i class="fas fa-upload"></i>
                        </span>
                        <span class="file-label">
                            Choose a file…
                        </span>
                    </span>
                    <span class="file-name">
                        No file selected
                    </span>
                </label>&nbsp;

                <button id="uploadButton" class="button is-dark">Upload</button>
            </div>

            <div id="uploadStatus">
                <div id="uploadStatusProgress"></div>
                <div id="uploadStatusProgress2"></div>
            </div>
            <div id="uploadErrorMessage"></div>
            <div id="uploadFileResult">
                <input id="uploadFileLink" type="text" value="" readonly />
                <button id="copyToClipBoardButton" class="button is-dark">Copy link</button>
                <button id="sendLinkInEmailButton" class="button is-dark">Send link in email</button>
                <br/><br/>
                <a href="/transfers">Upload new file</a>

            </div>

            <ul>
                <li>DISCLAIMER: This tool <strong>does not scan uploaded files</strong> for <em>malicious content</em>.</li>
                <li>Transfer file between computers/phones up to [<strong><?= $maxFileSizeInMb; ?>]</strong> Mb.</li>
                <li>Download links are active for [ <strong><?= $maxFileAgeInHours; ?></strong> ] hours.</li>
                <li>If uploaded file is not itself a zip file, the uploaded file will be added to a compressed [<strong>zip-file</strong>] by this tool - that can be downloaded and extracted.</li>
                <li>If you want to upload many files at the same time, you can upload them in a zip-file.</li>
                <li>Uploaded zip-files will be renamed to a unique file name.</li>
                <li>Allowed file extensions [ <strong><?= $fileExtensionsAllowed; ?></strong> ]</li>
                <li>Suggestions to this tool, please contact <a href="mailto:grosen@grosen.tools">grosen@grosen.tools</a></li>
            </ul>


            <?php /* <orm action="/transfer-upload" method="post" enctype="multipart/form-data" id="transferUploadForm">
                <input id="file" name="file" type="file" />
                <button id="uploadButton" class="button is-dark">Upload</button>
            </form> */ ?>

        </div>
        <div style="text-align: right;"><em>No user data are tracked on this website</em></div>
    </div>

<?php } else if ($_viewFileSection == 'footer') { ?>



<?php } ?>

