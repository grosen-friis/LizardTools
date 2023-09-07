<?php
/* if (!isset($data['token']) || $data['token'] === NULL || !is_string($data['token'])) {
    exit;
} */
?>
<?php if ($_viewFileSection == 'responseheader') { ?>

<?php } else if ($_viewFileSection == 'head') { ?>

    <link rel="canonical" href="https://grosen.tools" />
    <link rel="alternate" hreflang="en" href="https://grosen.tools" />
    <link rel="alternate" hreflang="x-default" href="https://grosen.tools" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css" />
    <script type="application/javascript" src="/js/common.js"></script>

<?php } else if ($_viewFileSection == 'body') { ?>

    <div class="container is-max-desktop">
        <div class="notification has-background-white content">

            <a href="/"><h1>Online tools</h1></a>
            <p><?= $viewMetaDescription; ?></p>

            <table class="table is-striped">
                <thead>
                    <tr>
                        <th><span class="tag is-medium">Link</span></th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><a href="/password-generator">Online password generator</a></td>
                        <td>
                            <p>Generate up to 50 passwords with the length and content you specify</p>
                        </td>
                    </tr>
                    <tr>
                        <td><a href="/spintext-generator">Online spin-text generator</a></td>
                        <td>
                            <p>Generate and download thousands of unique texts based on your spintax.</p>
                        </td>
                    </tr>
                    <tr>
                        <td><a href="/transfers">Transfer large file</a></td>
                        <td>
                            <p>Upload large file and get download link that you can share.</p>
                        </td>
                    </tr>
                </tbody>
            </table>

            <hr style="background-color: #000000;" />

            <h2>Online APIs</h2>
            <p><?= $viewApiMetaDescription; ?></p>

            <table class="table is-striped">
                <thead>
                <tr>
                    <th><span class="tag is-medium">Method</span></th>
                    <th>Description</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td></td>
                    <td>
                        <p>Generate up to 50 passwords with the length and content you specify</p>
                    </td>
                </tr>
                <tr>
                    <td>GET:</td>
                    <td>
                        <p style="word-break: break-all;" class="is-family-monospace">/api/password/length/<strong>{password_length}</strong>/count/<strong>{number_of_password}</strong>/datasets/<strong>{data_set_ids}</strong></p>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <ul>
                            <li>Output format: JSON</li>
                            <li>Password length e.g.: 24</li>
                            <li>Number of passwords e.g.: 5</li>
                            <li>Data set IDs e.g.: 125
                                <ul>
                                    <li>Data set 1: [<span class="is-family-monospace">a-z</span>]</li>
                                    <li>Data set 2: [<span class="is-family-monospace">A-Z</span>]</li>
                                    <li>Data set 3: [<span class="is-family-monospace">0-9</span>]</li>
                                    <li>Data set 4: [<span class="is-family-monospace">+-!#¤%&=?€£$@</span>]</li>
                                    <li>Data set 5: [<span class="is-family-monospace">.,;:_^~*|/?=()[]{}</span>]</li>
                                </ul>
                            </li>

                        </ul>
                        <p style="word-break: break-all;" class="is-family-monospace">Click here to test: <a href="https://grosen.tools/api/password/length/24/count/5/datasets/125">/api/password/length/24/count/5/datasets/125</a></p>

                    </td>
                </tr>
                </tbody>
            </table>


            <table class="table is-striped">
                <thead>
                <tr>
                    <th><span class="tag is-medium">Method</span></th>
                    <th>Description</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td></td>
                    <td>
                        <p>Generate spin-texts in the amount and via the spintax you specify</p>
                    </td>
                </tr>
                <tr>
                    <td>POST:</td>
                    <td>
                        <p style="word-break: break-all;" class="is-family-monospace">/api/spintext/count/<strong>{number_of_texts}</strong>/format/<strong>{csc_txt}</strong>/return/<strong>{text_zip}</strong></p>
                        <p>POST: spintax: Your spintax to be used to generate the spin-text</p>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <ul>
                            <li>Output format: JSON</li>
                            <li>count: Number of spin-texts to be generated. If your spin-tax is not able to generate the amount you specify the tool will return as many as it was possible to generate.</li>
                            <li>format: [csv|txt]</li>
                            <li>return: [text|zip]. Beware [text] can only be combined with format:[csv]. [zip] can be combined with both formats and the data returned will contains a unique URL where you can download the zip-file that contains the spin-texts file(s).</li>

                        </ul>
                        <p style="word-break: break-all;" class="is-family-monospace">To test this you need to use a tool like <a href="https://www.postman.com/downloads/">PostMan</a></p>

                    </td>
                </tr>
                </tbody>
            </table>


        </div>
        <div style="text-align: right;"><em>No user data are tracked on this website</em></div>
    </div>


<?php } else if ($_viewFileSection == 'footer') { ?>

<?php } ?>

