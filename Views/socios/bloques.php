<ul class="acuerdos">
    <?php
        $url = Link::Url('socios', 'ver', array (
            'id' => ':idacuerdo'
        ));
        echo Partial::fetchRows($_VARS['socios'], 
                "<li><a href='$url' class='bloques'><h3>:nombre</h3></a></li>");
    ?>
</ul>