<?php
/* if (!isset($data['token']) || $data['token'] === NULL || !is_string($data['token'])) {
    exit;
} */
?>
<?php if ($_viewFileSection == 'responseheader') { ?>

<?php } else if ($_viewFileSection == 'head') { ?>


    <link rel="canonical" href="https://grosen.tools/password-generator" />
    <link rel="alternate" hreflang="en" href="https://grosen.tools/password-generator" />
    <link rel="alternate" hreflang="x-default" href="https://grosen.tools/password-generator" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css" />
    <link rel="stylesheet" type="text/css" href="/plugin/LizardTools/css/password_generator.css" />

    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://grosen.tools/password-generator" />
    <meta property="og:title" content="<?= $viewTitle ?>" />
    <meta property="og:description" content="<?= $viewMetaDescription; ?>" />
    <meta property="og:image:url" content="https://grosen.tools/plugin/LizardTools/img/password.png"/>
    <meta property="og:image:secure_url" content="https://grosen.tools/plugin/LizardTools/img/password.png"/>
    <meta property="og:image:type" content="image/png"/>
    <meta property="og:image:width" content="1920"/>
    <meta property="og:image:height" content="907"/>
    <meta property="og:image:alt" content="<?= $viewTitle ?>"/>
    <meta property="og:locale" content="en" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:title" content="<?= $viewTitle ?>" />
    <meta name="twitter:description" content="<?= $viewMetaDescription; ?>" />
    <meta name="twitter:image" content="https://grosen.tools/plugin/LizardTools/img/password.png">

    <script type="application/javascript" src="/js/common.js"></script>

    <script type="module">
        import {setHttpHost, generatePassword } from '/plugin/LizardTools/js/lizard_tools.js';
        setHttpHost('https://<?= $_SERVER['HTTP_HOST']; ?>');

        let elements = [];

        elements['errorMessageElement'] = document.getElementById('errorMessage');
        elements['passwordLengthElement'] = document.getElementById('passwordLength');
        elements['passwordCountElement'] = document.getElementById('passwordCount');
        elements['passwordCharacterSet1Element'] = document.getElementById('passwordCharacterSet1');
        elements['passwordCharacterSet2Element'] = document.getElementById('passwordCharacterSet2');
        elements['passwordCharacterSet3Element'] = document.getElementById('passwordCharacterSet3');
        elements['passwordCharacterSet4Element'] = document.getElementById('passwordCharacterSet4');
        elements['passwordCharacterSet5Element'] = document.getElementById('passwordCharacterSet5');
        elements['generatedPasswordsElement'] = document.getElementById('generatedPasswords');
        elements['goToTOpButtonElement'] = document.getElementById('goToTOpButton');

        document.getElementById('generatePasswordButton').addEventListener('click', (e) => { generatePassword(e.target, elements); });

    </script>

<?php } else if ($_viewFileSection == 'body') { ?>

    <div class="container is-max-desktop">
        <div class="notification has-background-white content">

            <a name="top"></a>
            <p>&lt;&lt;&nbsp;<a href="/">home</a></p>
            <a href="/password-generator"><h1>Password generator</h1></a>

            <div id="errorMessage"></div>

            <div class="field is-horizontal">
                <div class="field-label">
                    <label for="passwordLength" class="label">Password length</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <label class="checkbox">
                                <input type="text" name="passwordLength" id="passwordLength" value="12" class="input" placeholder="Password length [6 -&gt; 2048]" />
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="field is-horizontal">
                <div class="field-label">
                    <label for="passwordCount" class="label">Number of passwords</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <label class="checkbox">
                                <input type="text" name="passwordCount" id="passwordCount" value="1" class="input" placeholder="Passwords count [1-&gt; 50]" />
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="field is-horizontal">
                <div class="field-label">
                    <label for="passwordCharacterSet1" class="label">Include [a-z]</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <label class="checkbox">
                                <input type="checkbox" name="passwordCharacterSet1" id="passwordCharacterSet1" class="checkbox" value="abcdefghijklmnopqrstuvwxyz" checked />
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="field is-horizontal">
                <div class="field-label">
                    <label for="passwordCharacterSet2" class="label">Include [A-Z]</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <label class="checkbox">
                                <input type="checkbox" name="passwordCharacterSet2" id="passwordCharacterSet2" class="checkbox" value="ABCDEFGHIJKLMNOPQRSTUVWXYZ" checked />
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="field is-horizontal">
                <div class="field-label">
                    <label for="passwordCharacterSet3" class="label">Include [0-9]</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <label class="checkbox">
                                <input type="checkbox" name="passwordCharacterSet3" id="passwordCharacterSet3" class="checkbox" value="0123456789" checked />
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="field is-horizontal">
                <div class="field-label">
                    <label for="passwordCharacterSet4" class="label">Include [+-!#¤%&amp;=?€£$@]</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <label class="checkbox">
                                <input type="checkbox" name="passwordCharacterSet4" id="passwordCharacterSet4" class="checkbox" value="+-!#¤%&=?€£$@" />
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="field is-horizontal">
                <div class="field-label">
                    <label for="passwordCharacterSet5" class="label">Include [.,;:_^~*|/?=()[]{}]</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <label class="checkbox">
                                <input type="checkbox" name="passwordCharacterSet5" id="passwordCharacterSet5" class="checkbox" value=".,;:_^~*|/?=()[]{}<>" />
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="field is-horizontal">
                <div class="field-label">

                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <label class="checkbox">
                                <button id="generatePasswordButton" class="button is-dark">Generate password(s)</button>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <br/>

            <a name="generatedPasswords"></a>
            <table class="table is-striped">
                <thead>
                    <tr>
                        <th><span class="tag is-medium">#</span></th>
                        <th>Password</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="generatedPasswords">

                </tbody>
            </table>

            <div class="field is-horizontal">
                <div class="field-label">

                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <label class="checkbox">
                                <button id="goToTOpButton" class="button is-dark hideElement" onclick="document.location.href='#top';">Go to top</button>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div style="text-align: right;"><em>No user data are tracked on this website</em></div>
    </div>


<?php } else if ($_viewFileSection == 'footer') { ?>



<?php } ?>

