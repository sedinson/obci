<ul class="acuerdos">
    <?php
        $url = Link::Url('socios', 'ver', array (
            'id' => ':idacuerdo'
        ));
        echo Partial::fetchRows($_VARS['socios'], 
                "<li><a href='$url' style='background: url(:bandera) no-repeat center center;'></a><h3>:nombre</h3></li>");
    ?>
</ul>