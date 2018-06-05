<?php

require "config.php";

$url = $conf["base_url"].$conf["folder"]."/api/";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Myanmar Lorem Ipsum dummy text generator. This can generate dummy text in Burmese language. Both Unicode and Zawgyi are supported. "/>
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?php echo $conf["title"]; ?>" />
    <meta property="og:url" content="<?php echo $conf["base_url"]; ?>/" />
    <meta property="og:site_name" content="Myanmar Lorem Ipsum Dummy Text Generator" />
    <title><?php echo $conf["title"]; ?></title>
    <link rel="stylesheet" href="vendors/bootstrap/bootstrap.min.css">
    <script src="vendors/bootstrap/jquery.min.js"></script>
    <script src="vendors/bootstrap/bootstrap.min.js"></script>
<style type="text/css">

div {
}

main {
    padding: 2%;
}

textarea {
    padding: 20px;
    font-family: Zawgyi-One;
    margin-bottom: 10px;
    width: 100%
}
body {
    font: 14px Arial, Helvetica;
    padding: 2%;
}
input {
    width: 80%;
    padding: 10px;
}
select {
    width: 100%;
    padding: 10px;
}
td {
    padding: 0 10px;
}

    hr {
        border: none;
        height: 1px;
        background: #dddddd;
    }

    header {
        text-align: center;
    }

</style>
<script type="text/javascript">

function newText()
{
    var paragraph   = document.getElementById("paragraph").value;
    var minLines    = document.getElementById("minLines").value;
    var maxLines    = document.getElementById("maxLines").value;
    var encoding    = document.getElementById("encoding").value;
    var htmlCode    = document.getElementById("htmlCode").value;
    var url         = "<?php echo $conf["base_url"].$conf["folder"] ?>/api/para"+paragraph+"/min"+minLines+"/max"+maxLines+"/"+encoding+"/"+htmlCode;

    var text =  httpGet(url);
    document.getElementById("dummyText").value = text.trim();
}

function  changeFont() {
    var font = document.getElementById("encoding").value;
    if(font == "zg"){
        document.getElementById("dummyText").style.fontFamily = "Zawgyi-one, Zawgyi1";
    }else{
        document.getElementById("dummyText").style.fontFamily = "Myanmar3, 'Myanmar Text, Myanmar2'";
    }
}

function httpGet(theUrl)
{
    var xmlHttp = null;

    xmlHttp = new XMLHttpRequest();
    xmlHttp.open( "GET", theUrl, false );
    xmlHttp.send( null );
    return xmlHttp.responseText;
}
</script>
</head>
<body>

<div class="jumbotron text-center">
<header>
    <h1>Myanmar Lorem Ipsum</h1>
    <p>Dummy Text Generator Version 1.0</p>
</header>
    <hr>

    <table width="100%" border="0">
        <tr>
            <td rowspan="6">
                <textarea id="dummyText" rows="14" onclick="javascript: this.select()">
                
                </textarea>
            </td>
            <td width="100" align="right"><label for="paragraph" class="text-left">Paragraph</label></td>
            <td width="100" ><input id="paragraph" type="number" class="input-sm" value="4" /></td>
        </tr>
        <tr>
            <td  align="right"><label for="minLines" class="text-left">Min. Lines</label></td>
            <td ><input id="minLines" type="number" class="input-sm" value="2" /></td>
        </tr>
        <tr>
            <td align="right"><label for="maxLines" class="text-left">Max. Lines</label></td>
            <td ><input id="maxLines" type="number" class="input-sm" value="6" /></td>
        </tr>
        <tr>
            <td align="right"><label for="encoding" class="text-left">Encoding</label></td>
            <td ><select id="encoding" class="input-sm" onchange="changeFont()">
                    <option value="zg" selected>Zawgyi</option>
                    <option value="uni">Unicode</option>
                </select></td>
        </tr>
        <tr>
            <td align="right"><label for="htmlCode" class="text-left">Encoding</label></td>
            <td ><select id="htmlCode" class="input-sm">
                    <option value="html">HTML On</option>
                    <option value="plain" selected>HTML Off</option>
                </select></td>
        </tr>
        <tr>
            <td colspan="2" align="right"><input id="generateBtn" type="button" class="btn-lg" value="Generate Text" onclick="newText()" /></td>
        </tr>
    </table>
<hr>
<main>
    <h2>API</h2>
    <h3>Format:</h3>
    <p>
        <?php echo $url ?> para(1-30) / min(1-29) / max(1-30) / (html|plain) / (zg|uni)
    </p>
    <h3>Example</h3>
    <p>
        <a href="<?php echo $url; ?>para4/min2/max6/plain/zg" target="_blank"><?php echo $url; ?>para4/min2/max6/plain/zg</a>
    </p>
    <p>
        Parameter order can be changed.
    </p>
    <p>
    <a href="<?php echo $url; ?>min2/para4/max6/uni/html" target="_blank"><?php echo $url; ?>min2/para4/max6/uni/html</a>
    </p>
</main>
<footer>
    Copy R
</footer>
</div>
<script type="text/javascript">
    newText();
</script>
</body>
</html>