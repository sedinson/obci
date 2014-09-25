<html>
	<head>
        <meta charset="utf-8" />
        <link href="<?php echo Link::Absolute('Resource/imgs/icon.jpg'); ?>" type="image/x-icon" rel="shortcut icon" />
        <link rel="apple-touch-icon" href="<?php echo Link::Absolute('Resource/imgs/icon.jpg'); ?>"/>
        <link rel="apple-touch-startup-image" href="<?php echo Link::Absolute('Resource/imgs/icon.jpg'); ?>" />
        <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,600,300' rel='stylesheet' type='text/css' />
        <?php
            Link::loadStyle('Resource/load.php?file=admin.css&type=text/css', 'text/css', 'stylesheet', 'screen');
            Link::loadStyle('Resource/load.php?file=fonts/font-awesome.min.css&type=text/css', 'text/css', 'stylesheet', 'screen');
            Link::loadStyle('Resource/load.php?file=icons/style.css&type=text/css', 'text/css', 'stylesheet', 'screen');
            Link::loadStyle('Resource/load.php?file=jqvmap.css&type=text/css');
        ?>

        <!--[if lt IE 9]>
        <?php
            Link::loadScript('Scripts/js/html5.js');
            Link::loadScript('Scripts/js/coverfix/jquery.backgroundSize.min.js');
        ?>
        <![endif]-->
        
        <!--Javascript-->
        <?php
            Link::loadScript('Scripts/load.php?file=js/jquery.min.js&type=text/javascript');
            Link::loadScript('Scripts/load.php?file=js/imageviewer.js&type=text/javascript');
            Link::loadScript('Scripts/js/tinymce/tinymce.min.js');
            Link::loadProjectBase();
        ?>
        <title>OBCI - Admin</title>
	</head>
	<body>
        <div id="admin-panel">
            <div id="header">
                <i class="icomoon-logo-siinsiin"></i>
                
                <div class="lefty">
                    <a class="icon icon-signout" title="Cerrar Sesión" onclick="javascript:logout();"></a>
                    <a class="icon icon-th" title="Configuracion Cuentas de Usuarios" onclick="javascript:configure();"></a>
                    <a id="h-user">...</a>
                </div>
            </div>
            
            <div id="tabs">
                <ul class="tabs">
                    <li>
                        <a class="tiny" href="#start" title="Pagina de Inicio" onclick="javascript:changeTab(5);">
                            <i class="icon-star"></i> &nbsp;</a>
                    </li>
                    
                    <li class="select" onclick="javascript:changeTab(0);">
                        <a href="#slides"><i class="icon-download"></i> Importar Datos</a>
                    </li>
                    
                    <li>
                        <a href="#projects" onclick="javascript:changeTab(1);">
                            <i class="icon-map-marker"></i> Mapas</a>
                    </li>
                    
                    <li>
                        <a href="#Flow" onclick="javascript:changeTab(2);">
                            <i class="icon-flag"></i> Flujos Comerciales</a>
                    </li>

                    <li>
                        <a class="tiny" href="#people" title="Explorador de Archivos" onclick="javascript:changeTab(3);">
                            <i class="icon-file"></i> &nbsp;</a>
                    </li>

                    <li>
                        <a class="tiny" href="#installation" title="Socios Comerciales" onclick="javascript:changeTab(4);">
                            <i class="icon-group"></i> &nbsp;</a>
                    </li>
                </ul>
                
                <div id="tabs-area">
                    <div class="tab" id="chat">
                        <div class="list">
                            <h2>Plantillas</h2>
                            
                            <h3>Importaciones / Exportaciones</h3>
                            <div class="row">
                                <p>
                                    <a href="<?php echo Link::Absolute('Resource/plantillas/Plantilla_Expo_Impo_Apertura.xlsx'); ?>"><i class="icon-file-text"></i> Por Departamentos</a>
                                </p>
                            </div>
                            
                            <div class="row">
                                <p>
                                    <a href="<?php echo Link::Absolute('Resource/plantillas/Plantilla_Expo_Impo_Paises.xlsx'); ?>"><i class="icon-file-text"></i> Por Paises</a>
                                </p>
                            </div>
                            
                            <div class="row">
                                <p>
                                    <a href="<?php echo Link::Absolute('Resource/plantillas/Plantilla_Puertos.xlsx'); ?>"><i class="icon-file-text"></i> Por Puertos</a>
                                </p>
                            </div>
                            
                            <div class="row">
                                <p>
                                    <a href="<?php echo Link::Absolute('Resource/plantillas/Plantilla_Zonas_Francas.xlsx'); ?>"><i class="icon-file-text"></i> Por Zonas Francas</a>
                                </p>
                            </div>
                            
                            <div class="row">
                                <p>
                                    <a href="<?php echo Link::Absolute('Resource/plantillas/Plantilla_Zonas_Francas_OD.xlsx'); ?>"><i class="icon-file-text"></i> Por Zonas Francas (O/D)</a>
                                </p>
                            </div>
                            
                            <h3>Capitulos</h3>
                            <div class="row">
                                <p>
                                    <a href="<?php echo Link::Absolute('Resource/plantillas/Plantilla_Capitulos_Arancel.xlsx'); ?>"><i class="icon-file-text"></i> Capitulos</a>
                                </p>
                            </div>
                            
                            <div class="row">
                                <p>
                                    <a href="<?php echo Link::Absolute('Resource/plantillas/Plantilla_RCA_Index_Departamentos.xlsx'); ?>"><i class="icon-file-text"></i> Departamentos Por Capitulos</a>
                                </p>
                            </div>
                            
                            <h3>Otros</h3>
                            <div class="row">
                                <p>
                                    <a href="<?php echo Link::Absolute('Resource/plantillas/Plantilla_Exportaciones_Caribe.xlsx'); ?>"><i class="icon-file-text"></i> Exportaciones Caribe</a>
                                </p>
                            </div>
                            
                            <div class="row">
                                <p>
                                    <a href="<?php echo Link::Absolute('Resource/plantillas/Plantilla_RCA_Index_Countries.xlsx'); ?>"><i class="icon-file-text"></i> RCA Index</a>
                                </p>
                            </div>
                            
                            <div class="row">
                                <p>
                                    <a href="<?php echo Link::Absolute('Resource/plantillas/Plantilla_ihh.xlsx'); ?>"><i class="icon-file-text"></i> IHH</a>
                                </p>
                            </div>
                        </div>
                        
                        <div class="body">
                            <form id="frm-imp">
                                <div class="s75">
                                    <select class="estira" name="tipo" id="tipo">
                                        <option value="-1">Seleccione un tipo...</option>
                                        <optgroup label="Importaciones / Exportaciones">
                                            <option value="dept_imp_exp">Importacion/Exportacion por Departamento</option>
                                            <option value="pais_imp_exp">Importacion/Exportacion por Pais</option>
                                            <option value="puerto_imp_exp">Importacion/Exportacion por Puerto</option>
                                            <option value="zf_imp_exp">Importacion/Exportacion por Zona Franca</option>
                                            <option value="zf_od_imp_exp">Importacion/Exportacion por Zona Franca (Origen/Destino)</option>
                                        </optgroup>

                                        <optgroup label="Capitulos">
                                            <option value="dept_capitulo">Departamentos por Capitulo</option>
                                            <option value="capitulo">Capitulos (Cuidado!)</option>
                                        </optgroup>

                                        <optgroup label="Otros">
                                            <option value="caribe_exp">Exportaciones Caribe</option>
                                            <option value="rca_index">RCA Index</option>
                                            <option value="ihh">IHH</option>
                                        </optgroup>
                                    </select>
                                </div>
                                
                                <div class="s25">
                                    <button class="estira red" id="removinator"><i class="icon-remove-sign"></i> Eliminar</button>
                                </div>
                                
                                <input type="text" class="estira" name="archivo" placeholder="Archivo Excel (*.xlsx)" />
                                
                                <div id="descripcion">
                                    <p style="color: #676662">Pantalla de resultados</p>
                                </div>
                                
                                <button class="estira"><i class="icon-download-alt"></i> Importar</button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="tab" id="news">
                        <div class="list"></div>
                        
                        <div class="body">
                            <form id="frm-pos">
                                <input type="text" class="estira" name="nombre" placeholder="Nombre" />
                                <input type="hidden" id="latitud" name="latitud" />
                                <input type="hidden" id="longitud" name="longitud" />
                                
                                <select class="estira" name="tipo">
                                    <option value="zona franca">Zona Franca</option>
                                    <option value="puerto">Puerto</option>
                                </select>
                                
                                <select class="estira" name="departamento">
                                    <?php echo Partial::fetchRows($_VARS['departamentos'], 
                                            "<option>:departamento</option>"); ?>
                                </select>
                                
                                <div id="map-canvas"></div>
                                
                                <button class="estira"><i class="icon-save"></i> Guardar</button>
                            </form>
                        </div>
                    </div>

                    <div class="tab" id="people">
                        <div class="list"></div>
                        
                        <div class="body">
                            <form id="frm-flow">
                                <select class="estira" name="pais">
                                    <?php echo Partial::fetchRows($_VARS['paises'], 
                                            "<option>:nombre</option>"); ?>
                                </select>
                                
                                <input type="hidden" name="codigo" id="_code" />
                                
                                <div class="ahoy">
                                    <div id="mapflow"></div>
                                </div>
                                
                                <button class="estira"><i class="icon-save"></i> Guardar</button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="tab" id="photos">
                        <iframe id="loadfile" src=""></iframe>
                        <div id="location_bar">
                            <button id="btn_up" class="icon-chevron-sign-up"></button>

                            <div id="location">
                                <ul></ul>
                            </div>
                            
                            <button id="btn_new_folder" class="icon-folder-close"></button>
                            <button id="btn_upload" class="icon-cloud-upload"></button>
                        </div>

                        <div id="explorer"></div>
                    </div>

                    <div class="tab" id="installation">
                        <div class="list"></div>
                        
                        <div class="body">
                            <form id="frm-socios">
                                <select class="estira" name="tipo" id="stipo">
                                    <option value="socios">Socios Comerciales Bilaterales</option>
                                    <option value="bloques">Bloques Regionales</option>
                                </select>
                                
                                <input class="estira" id="sbandera" type="text" name="bandera" placeholder="Bandera" />
                                
                                <input class="estira" id="snombre" type="text" name="nombre" placeholder="Pais o Grupo" />
                                
                                <select class="estira" name="acuerdo" id="sacuerdo">
                                    <option value="suscrito">Acuerdo Suscrito</option>
                                    <option value="vigente">Acuerdo Vigente</option>
                                    <option value="en curso">Acuerdo en Curso</option>
                                </select>
                                
                                <input class="estira" type="text" id="senlace" name="enlace" placeholder="Enlace al acuerdo" />
                                
                                <h2>Perfil Economico</h2>
                                <textarea class="editme" id="sperfil" name="perfil"></textarea>
                                
                                <h2>Historia</h2>
                                <textarea class="editme" id="shistoria" name="historia"></textarea>
                                
                                <h2>Acceso a Mercados</h2>
                                <textarea class="editme" id="sobjetivo" name="objetivo"></textarea>
                                
                                <h2>Desgravación [OCULTO]</h2>
                                <textarea class="editme" id="sdesgraviacion" name="desgraviacion"></textarea>
                                
                                <button class="estira"><i class="icon-save"></i> Guardar</button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="tab" id="start">
                        <div class="body full">
                            <textarea class="editme" id="pagina_principal"></textarea>
                            <button class="estira" onclick="javascript:saveInitPage();"><i class="icon-save"></i> Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="login">
            <form id="frm-login">
                <i class="logo icomoon-logo-siinsiinmovil"></i>
                <p>
                    <input type="text" id="user" name="user" placeholder="Usuario" />
                </p>
                
                <p>
                    <input type="password" id="pass" name="pass" placeholder="Clave" />
                </p>
                
                <p>
                    <button>Iniciar Sesion</button>
                </p>
            </form>
        </div>
            
            <div id="config-admin">
                <div id="forms">
                    <a class="close icon-remove-sign"></a>
                    <h2>Cambiar Contraseña</h2>
                    <form id="frm-pass">
                        <input type="password" placeholder="Nueva contraseña" name="pass" />
                        <input type="password" placeholder="Repita nueva contraseña" name="new" />

                        <button><i class="icon-key"></i> Cambiar Contraseña</button>
                    </form>

                    <h2>Agregar Usuario</h2>
                    <form id="frm-new-user">
                        <input type="text" placeholder="Nombre Completo" name="nombre" />
                        <input type="text" placeholder="Usuario" name="usuario" />
                        <input type="password" placeholder="contraseña" name="pass" />
                        <input type="password" placeholder="Repita contraseña" name="new" />

                        <button><i class="icon-plus-sign-alt"></i> Agregar Usuario</button>
                    </form>
                </div>
            </div>
            
        <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBcolSfvTtbbMXBANh9SMhOcxYGTOIowtU&sensor=true"></script>
        
        <?php 
            Link::loadScript('Scripts/load.php?file=js/jqvmap/jquery.vmap.min.js&type=text/javascript');
            Link::loadScript('Scripts/load.php?file=js/jqvmap/jquery.vmap.min.js&type=text/javascript');
            Link::loadScript('Scripts/load.php?file=js/jqvmap/maps/jquery.vmap.world.js&type=text/javascript');
            Link::loadScript('Scripts/load.php?file=js/jqvmap/data/jquery.vmap.sampledata.js&type=text/javascript'); 
        ?>
        
        <script type="text/javascript">
            tinymce.init({
                selector: "textarea.editme",
                plugins: [
                    "advlist autolink lists link image charmap preview anchor",
                    "searchreplace visualblocks",
                    "table contextmenu paste"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
            });
        </script>
        
        <script type="text/javascript">
            /*Iniciar el LinkServer y eventos para obtener la informacion*/
            var LinkServer = new Linker("<?php echo Link::Absolute(); ?>");
            LinkServer.setExtension(".json?");

            var LinkPage = new Linker("<?php echo Link::Absolute(); ?>");
            LinkPage.setExtension("/");
            
            var nombre = "", usuario = "",
                mapa = null, marker = null;
            
            var uget = function (params) {
                return $.ajax({
                    type: (params.type)? params.type : 'GET',
                    url: (params.url)? params.url : '',
                    data: (params.data)? params.data : {},
                    xhrFields: {
                        withCredentials: true
                    },
                    crossDomain: true
                });
            };

            var dir = [];

            /*Listar archivos*/
            function scandir () {
                var location = $("#location ul");
                location.html("<li onclick=\"javascript:back_folders(-1)\"><i class='icon-home'></i> <i class='icon-caret-right'></i></li>");

                for(var i=0; i<dir.length; i++) {
                    location.append("<li onclick=\"javascript:back_folders(" + i + ")\">" 
                        + dir[i] + " <i class='icon-caret-right'></i></li>");
                }

                $("#explorer").html("<p style='text-align:center;margin-top:36px;'><i style='font-size:36px;' class='icon-spinner'></i></p>");

                var strdir = dir.join('/');
                strdir += (dir.length > 0)? '/' : '';

                uget({
                    type: 'GET',
                    url: LinkServer.Url('file', 'scan', {
                        dir: encodeURI(strdir)
                    })
                }).done(function (data) {
                    var explorer = $("#explorer");
                    if(data._code === 200) {
                        explorer.html("");
                        for(var i=0; i<data._response.scan.length; i++) {
                            var ob = data._response.scan[i],
                                str = "<div class='item' onclick=\"javascript:"
                                    + "open_" + ob.type + "('" + ob.name + "');\"><div class='center'><img src='" 
                                    + ((ob.type === "folder")? '<?php echo Link::Absolute('res/folder.png') ?>' : 
                                        LinkServer.Url('file', 'thumb', {
                                            dir: encodeURI(strdir + ob.name)
                                        })) + "' /></div>"
                                    + "<p>" + ob.name + "</p></div>";

                            explorer.append(str);
                        }

                        $("#loadfile").contents().find("#inputname").val(strdir);

                        if(data._response.scan.length === 0) {
                            $("#explorer").html("<p style='text-align:center;margin-top:36px;'>Carpeta vacia. </p>"
                                + "<p style='text-align:center;'><button class='eliminable'><i class='icon-trash'></i> Eliminar</button></p>");

                            $(".eliminable").click(function () {
                                delete_file('');
                            });
                        }
                    } else {
                        alert("Problemas al abrir directorio:" + data._message);
                    }
                });
            }

            function timeConverter(UNIX_timestamp){
                var a = new Date(UNIX_timestamp*1000),
                    months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
                    year = a.getFullYear(),
                    month = months[a.getMonth()],
                    date = a.getDate(),
                    hour = a.getHours(),
                    min = a.getMinutes(),
                    sec = a.getSeconds(),
                    time = date + ',' + month + ' ' + year + ' ' + hour + ':' + min + ':' + sec;

                return time;
            }

            /*Iniciar el creado de nueva carpeta*/
            function new_folder () {
                var explorer = $("#explorer");
                var str = "<div class='item select'><div class='center'><img src='<?php echo Link::Absolute('res/folder.png'); ?>' /></div>"
                        + "<p><textarea class='new_folder' placeholder='Nueva Carpeta'></textarea></p></div>";

                explorer.find(".select").remove();
                explorer.append(str);
                explorer.find(".select").find("textarea").focus();
                explorer.scrollTop(999999);
                $(".new_folder").blur(function () {
                    create_folder($(this).val());
                });

                $(".new_folder").keydown(function (e) {
                    var code = (e.wich)? e.wich : e.keyCode;
                    if(code == 13) {
                        e.preventDefault();
                        $(".new_folder").blur();
                    }
                });
            }

            /*Crear nueva carpeta*/
            function create_folder (str) {
                if(str == "") {
                    $("#explorer").find(".select").remove();
                } else {
                    var strdir = dir.join('/');
                    strdir += (dir.length > 0)? '/' : '';

                    uget({
                        type: 'GET',
                        url: LinkServer.Url('file', 'add', {
                            dir: encodeURI(strdir + str)
                        })
                    }).done(function (data) {
                        console.log(data);
                        if(data._code !== 200) {
                            alert("No se pudo crear la carpeta");
                            $("#explorer").find(".select").remove();
                        } else {
                            scandir();
                        }
                    });
                }
            }

            function open_folder (str) {
                dir.push(str);
                scandir();
            }

            function delete_file (str) {
                var strdir = dir.join('/');
                    strdir += (dir.length > 0)? '/' : '';

                var sw = confirm("Va a eliminar. Desea continuar?");
                if(sw) {
                    uget({
                        type: 'GET',
                        url: LinkServer.Url('file', 'delete', {
                            dir: encodeURI(strdir + str)
                        })
                    }).done(function (data) {
                        if(data._code === 200) {
                            if(str == '') {
                                dir.pop();
                            }
                            scandir();
                        } else {
                            alert("Imposible eliminar.");
                        }
                    });
                }
            }

            function open_file (str) {
                var strdir = dir.join('/');
                strdir += (dir.length > 0)? '/' : '';
                var explorer = $("#explorer");

                explorer.html("<p style='text-align:center;margin-top:36px;'><i style='font-size:36px;' class='icon-spinner'></i></p>");

                uget({
                    type: 'GET',
                    url: LinkServer.Url('file', 'info', {
                        dir: encodeURI(strdir + str)
                    })
                }).done(function (data) {
                    if(data._code === 200) {
                        var tmp = dir.slice(0),
                        ob = data._response;
                        tmp.push(str);
                        explorer.html("<h2>" + str + "</h2>"
                            + "<img class='preview' src='" + LinkPage.Absolute('res/elements/' + tmp.join('/')) + "' />");
                        explorer.append("<div class='file-info'><p><b>Link imagen:</b><input type='text' value='" + LinkPage.Absolute('res/elements/' + tmp.join('/')) + "'></p>"
                            + "<hr /><ul>"
                            + "<li><b>Tamaño:</b> " + ob.size + "B</li>"
                            + "<li><b>Creado:</b> " + timeConverter(ob.ctime) + "</li>"
                            + "<li><b>Modificado:</b> " + timeConverter(ob.mtime) + "</li>"
                            + "<li><b>Ultimo acceso:</b> " + timeConverter(ob.atime) + "</li>"
                            + "</ul><button class='eliminable'><i class='icon-trash'></i> Eliminar</button></div>");

                        $(".eliminable").click(function () {
                            delete_file(str);
                        });
                    } else {
                        explorer.html("<h1>Algo no salio como lo planeado :(</h1>");
                        explorer.append("<p>" + data._message + "</p>");
                    }
                });
            }

            function upload_file() {
                $("#loadfile").contents().find("body")
                    .find("#inputfile").trigger("click");
            }

            function back_folders (i) {
                dir = dir.slice(0, i+1);
                scandir();
            }
            
            /*Logout*/
            function logout () {
                uget({
                    type: 'GET',
                    url: LinkServer.Url('user', 'logout', [])
                }).done(function () {
                    $("#login").css({
                        opacity: 0,
                        display: 'block'
                    }).animate({
                        opacity: 1
                    }, 500);
                });
            }
            
            /*Configuracion de cuentas de usuarios*/
            function configure () {
                $("#config-admin").css({
                    display: 'block'
                });
            }
            
            $(function () {
                /*Formulario de login*/
                $("#frm-login").submit(function (e) {
                    e.preventDefault();
                    
                    uget({
                        type: 'POST',
                        url: LinkServer.Url('user', 'admin', []),
                        data: {
                            user: $("#user").val(),
                            pass: $("#pass").val()
                        }
                    }).done(function (data) {
                        if(data._code === 200) {
                            nombre = data._response.nombre;
                            usuario = data._response.usuario;
                            Socios.load();
                            Flujos.load();
                            ZF.load();
                            
                            scandir();
                            
                            $("#h-user").html(nombre);
                            $("#login").animate({
                                opacity: 0
                            }, {
                                duration: 500,
                                complete: function () {
                                    $("#login").css({
                                        display: 'none'
                                    });
                                }
                            });
                            
                            /*Cargar contenido de la pagina principal*/
                            uget({
                                type: 'GET',
                                url: LinkServer.Url('admin', 'main_page')
                            }).done(function (json) {
                                if(json._code === 200) {
                                    tinyMCE.get('pagina_principal').setContent(json._response.content);
                                } else {
                                    alert(json._message);
                                }
                            });
                        } else {
                            alert(data._message);
                        }
                    });
                    
                    return false;
                });
                
                /*Cerrar ventana de configuracion*/
                $("#forms .close").click(function () {
                    $("#config-admin").css({
                        display: 'none'
                    });
                });
                
                /*Cambiar Clave del usuario*/
                $("#frm-pass").submit(function (e) {
                    e.preventDefault();
                    
                    var tmp = $(this).serializeArray(),
                        params = {};
                        
                    for(var i in tmp) {
                        if(tmp[i].value !== "") {
                            params[tmp[i].name] = tmp[i].value;
                        }
                    }
                    
                    uget({
                        type: 'POST',
                        url: LinkServer.Url('user', 'change', []),
                        data: params
                    }).done(function (json) {
                        if(json) {
                            if(json._code === 200) {
                                alert("Clave cambiada.");
                            } else {
                                alert(json._message + ". Verifique que todos los campos estan llenos y vuelva a guardar.");
                            }
                        }
                    });
                    
                    return false;
                });
                
                /*Agregar un nuevo usuario*/
                $("#frm-new-user").submit(function (e) {
                    e.preventDefault();
                    
                    var tmp = $(this).serializeArray(),
                        params = {};
                        
                    for(var i in tmp) {
                        if(tmp[i].value !== "") {
                            params[tmp[i].name] = tmp[i].value;
                        }
                    }
                    
                    uget({
                        type: 'POST',
                        url: LinkServer.Url('user', 'add', []),
                        data: params
                    }).done(function (json) {
                        if(json) {
                            if(json._code === 200) {
                                alert("Usuario Agregado.");
                            } else {
                                alert(json._message + ". Verifique que todos los campos estan llenos y vuelva a guardar.");
                            }
                        }
                    });
                    
                    return false;
                });
            });
            
            /*Cambiar entre pestañas*/
            function changeTab (i) {
                var tabsy = [1, 2, 3, 4, 5, 0];
                $("#tabs .tabs li").removeClass("select");
                $("#tabs .tabs li").eq(tabsy[i]).addClass("select");
                
                $("#tabs-area .tab").css({
                    display: 'none'
                });
                $("#tabs-area .tab").eq(i).css({
                    display: 'block'
                });
                
                if(i === 1) {
                    if(mapa === null) {
                        /*Iniciar el mapa*/
                        var mapOptions = {
                            center: new google.maps.LatLng(3.8204080831949407,-72.7734375),
                            zoom: 6,
                            mapTypeId: google.maps.MapTypeId.ROADMAP,
                            mapTypeControl: true,
                            mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
                            navigationControl: true,
                            navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL}
                        };

                        mapa = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
                        
                        google.maps.event.addListener(mapa, 'click', function(event) {
                            var location = event.latLng;
                            
                            $("#latitud").val(location.lat());
                            $("#longitud").val(location.lng());
                            
                            if ( marker !== null ) {
                                marker.setPosition(location);
                            } else {
                                marker = new google.maps.Marker({
                                    position: location,
                                    map: mapa
                                });
                            }
                        });
                    }
                } else if (i === 2) {
                    $("#mapflow").html("").vectorMap({
                        map: 'world_en',
                        backgroundColor: '#f7f7f7',
                        borderColor: '#666666',
                        color: '#ffffff',
                        hoverOpacity: 0.7,
                        selectedColor: '#E30613',
                        enableZoom: true,
                        showTooltip: true,
                        values: sample_data,
                        scaleColors: ['#f7f7f7', '#dadada'],
                        normalizeFunction: 'polynomial',
                        onRegionClick: function(element, code, region) {
                            $("#_code").val(code);
                        }
                    });
                }
            }
            
            /*Resize*/
            $(function () {
                function resize () {
                    var H = $("#admin-panel").height(),
                        W = $("#admin-panel").width();
                    
                    $("#tabs").css({
                        height: H-100,
                        width: W
                    }, 250);
                    
                    $("#tabs-area").css({
                        height: H-161,
                        width: W-10
                    }, 250);
                    
                    $(".body, .footbar").css({
                        width: W-368
                    }, 250);
                    
                    $("#newsbody_ifr").css({
                        height: H-355
                    });
                    
                    $("#newstags").css({
                        width: W-455
                    });
                    
                    $(".msm").css({
                        height: H-260
                    });

                    $("#location").css({
                        width: W-127
                    });
                    $("#explorer").css({
                        height: H-200
                    });
                }
                
                $(window).resize(function () {
                    resize();
                });
                
                setTimeout(function () {
                    resize();
                }, 250);
            });
            
            
            /*Puntos Mapas Flujos Comerciales*/
            var Flujos = {
                load: function () {
                    uget({
                        type: 'GET',
                        url: LinkServer.Url('flujos', 'get', [])
                    }).done(function (data) {
                        //Lista en tab de slides
                        var list = $("#people .list");
                        
                        list.html("");

                        for (var i=0; i<data._response.length; i++) {
                            var ob = data._response[i];
                            
                            list.append("<div class='row'>"
                                        + "<p>" + ob.pais + "</p>"
                                        + "<a href='javascript:Flujos.delete(" + ob.idflujos_comerciales + ");' class='icon-trash'></a>");
                        }
                    });
                }, delete: function (id) {
                    var del = confirm("Desea eliminar el punto?");
                    
                    if(del) {
                        uget({
                            type: 'GET',
                            url: LinkServer.Url('flujos', 'delete', {
                                idflujos_comerciales: id
                            })
                        }).done(function (data) {
                            if(data._code === 200) {
                                Flujos.load();
                            } else {
                                alert("Hubo un error al eliminar. " + data._message);
                            }
                        });
                    }
                }
            };
            
            
            /*Zonas Francas*/
            var ZF = {
                load: function () {
                    uget({
                        type: 'GET',
                        url: LinkServer.Url('zonafranca', 'posiciones', {
                            tipo: encodeURIComponent('zona franca')
                        })
                    }).done(function (data) {
                        //Lista en tab de slides
                        var list = $("#news .list");
                        list.html("<h2>Zonas Francas</h2>");

                        for (var i=0; i<data._response.length; i++) {
                            var ob = data._response[i];

                            list.append("<div class='row'>"
                                        + "<img src='http://maps.googleapis.com/maps/api/staticmap?center=" + ob.latitud + "," + ob.longitud + "&zoom=14&size=335x131&maptype=roadmap&sensor=true' />"
                                        + "<p>" + ob.nombre + " <small> de " + ob.departamento + "</small></p>"
                                        + "<a href='javascript:ZF.delete(" + ob.idzf_pt + ")' class='icon-trash'></a>");
                        }
                        
                        uget({
                            type: 'GET',
                            url: LinkServer.Url('zonafranca', 'posiciones', {
                                tipo: encodeURIComponent('puerto')
                            })
                        }).done(function (data) {
                            list.append("<h2>Puertos</h2>");
                            
                            for (var i=0; i<data._response.length; i++) {
                                var ob = data._response[i];

                                list.append("<div class='row'>"
                                            + "<img src='http://maps.googleapis.com/maps/api/staticmap?center=" + ob.latitud + "," + ob.longitud + "&zoom=14&size=335x131&maptype=roadmap&sensor=true' />"
                                            + "<p>" + ob.nombre + " <small> de " + ob.departamento + "</small></p>"
                                            + "<a href='javascript:ZF.delete(" + ob.idzf_pt + ")' class='icon-trash'></a>");
                            }
                        });
                    });
                }, delete: function (id) {
                    var del = confirm("Desea eliminar el Punto?");
                    
                    if(del) {
                        uget({
                            type: 'GET',
                            url: LinkServer.Url('zonafranca', 'delete', {
                                idzf_pt: id
                            })
                        }).done(function (data) {
                            if(data._code === 200) {
                                ZF.load();
                            } else {
                                alert("Hubo un error al eliminar. " + data._message);
                            }
                        });
                    }
                }
            };
            
            
            /*Informacion de Socios Comerciales*/
            var Socios = {
                load: function () {
                    uget({
                        type: 'GET',
                        url: LinkServer.Url('socios', 'get', [])
                    }).done(function (data) {
                        //Lista en tab de slides
                        var list = $("#installation .list");
                    
                        //Establecer la data del mapa
                        list.html("");

                        for (var i=0; i<data._response.length; i++) {
                            var ob = data._response[i];
                            
                            list.append("<div class='row'>"
                                        + "<p onclick='javascript:Socios.edit(" + ob.idacuerdo + ");'>" + ob.nombre 
                                        + "<small>" + ob.tipo + " - " + ob.acuerdo + "<small></p>"
                                        + "<a href='javascript:Socios.delete(" + ob.idacuerdo + ");' class='icon-trash'></a>");
                        }
                    });
                }, delete: function (id) {
                    var del = confirm("Desea eliminar el acuerdo?");
                    
                    if(del) {
                        uget({
                            type: 'GET',
                            url: LinkServer.Url('socios', 'delete', {
                                idacuerdo: id
                            })
                        }).done(function (data) {
                            if(data._code === 200) {
                                Socios.load();
                            } else {
                                alert("Hubo un error al eliminar. " + data._message);
                            }
                        });
                    }
                }, edit: function (id) {
                    uget({
                        type: 'GET',
                        url: LinkServer.Url('socios', 'get', {
                            idacuerdo: id
                        })
                    }).done(function (data) {
                        if(data._code === 200) {
                            var ob = data._response[0];
                            
                            $("#stipo").val(ob.tipo);
                            $("#sbandera").val(ob.bandera);
                            $("#snombre").val(ob.nombre);
                            $("#sacuerdo").val(ob.acuerdo);
                            $("#senlace").val(ob.enlace);
                            tinyMCE.get('shistoria').setContent(ob.historia);
                            tinyMCE.get('sobjetivo').setContent(ob.objetivo);
                            tinyMCE.get('sperfil').setContent(ob.perfil);
                            tinyMCE.get('sdesgraviacion').setContent(ob.desgraviacion);
                            
                            alert("Datos cargados. Para editar borre el anterior y vuelva a guardar este.");
                        } else {
                            alert("No se pudo consultar. " + data._message);
                        }
                    });
                }
            };
            
            function saveInitPage () {
            	console.log("guardando pagina...");
                uget({
                    type: 'POST',
                    url: LinkServer.Url('admin', 'main_page', []),
                    data: {
                        content: tinyMCE.get('pagina_principal').getContent()
                    }
                }).done(function (json) {
                    if(json) {
                        if(json._code !== 200) {
                            alert(json._message + ". Verifique que todos los campos estan llenos y vuelva a guardar.");
                        } else {
                        	alert("Cambios guardados con éxito");
                        }
                    } else {
                    	alert("Ocurrió un error al guardar la pagina." + LinkServer.Url('admin', 'main_page', []));
                    }
                });
            }
            
            $(function () {
                $("#removinator").click(function (e) {
                    e.preventDefault();
                    var year = prompt("Escriba el año que desea eliminar");
                    
                    if(!isNaN(year)) {
                        uget({
                            type: 'POST',
                            url: LinkServer.Url('importar', 'delete', []),
                            data: {
                                tipo: $("#tipo").val(),
                                ano: year
                            }
                        }).done(function (data) {
                            //
                        });
                    }
                });
                
                $("#frm-imp").submit(function (e) {
                    e.preventDefault();
                    
                    var tmp = $(this).serializeArray(),
                        params = {};
                        
                    $("#descripcion").html("<p>Cargando variables...</p> <hr />");
                        
                    for(var i in tmp) {
                        if(tmp[i].value !== "") {
                            $("#descripcion").append("<p><b>" + tmp[i].name + "</b> --> " + tmp[i].value + "</p>");
                            params[tmp[i].name] = tmp[i].value;
                        }
                    }
                    
                    $("#descripcion").append("<p>&nbsp</p><p><i>Enviando petición al servidor...</i></p>");
                    
                    uget({
                        type: 'POST',
                        url: LinkServer.Url('importar', 'add', []),
                        data: params
                    }).done(function (json) {
                        $("#descripcion").append("<p>" + json._message + "</p>");
                        if(json) {
                            if(json._code === 200) {
                                $("#descripcion").append("<hr /> <p>Completado!</p>");
                            } else {
                                $("#descripcion").append("<hr /> <p>Falló</p>");
                                alert(json._message + ". Verifique que todos los campos estan llenos y vuelva a guardar.");
                            }
                        }
                    });
                    
                    return false;
                });
                
                /*Guardar nuevo Punto*/
                $("#frm-pos").submit(function (e) {
                    e.preventDefault();
                    
                    var tmp = $(this).serializeArray(),
                        params = {};
        
                    for(var i in tmp) {
                        if(tmp[i].value !== "") {
                            params[tmp[i].name] = tmp[i].value;
                        }
                    }
                    
                    uget({
                        type: 'POST',
                        url: LinkServer.Url('zonafranca', 'add', []),
                        data: params
                    }).done(function (json) {
                        if(json) {
                            if(json._code === 200) {
                                ZF.load();
                            } else {
                                alert(json._message + ". Verifique que todos los campos estan llenos y vuelva a guardar.");
                            }
                        }
                    });
                    
                    return false;
                });
                
                /*Guardar nuevo Flujo Comercial*/
                $("#frm-flow").submit(function (e) {
                    e.preventDefault();
                    
                    var tmp = $(this).serializeArray(),
                        params = {};
        
                    for(var i in tmp) {
                        if(tmp[i].value !== "") {
                            params[tmp[i].name] = tmp[i].value;
                        }
                    }
                    
                    uget({
                        type: 'POST',
                        url: LinkServer.Url('flujos', 'add', []),
                        data: params
                    }).done(function (json) {
                        if(json) {
                            console.log(json)
                            if(json._code === 200) {
                                Flujos.load();
                            } else {
                                alert(json._message + ". Verifique que todos los campos estan llenos y vuelva a guardar.");
                            }
                        }
                    });
                    
                    return false;
                });
                
                /*Guardar informacion de nuevo Socio Comercial*/
                $("#frm-socios").submit(function (e) {
                    e.preventDefault();
                    
                    var tmp = $(this).serializeArray(),
                        params = {};
        
                    for(var i in tmp) {
                        if(tmp[i].value !== "") {
                            params[tmp[i].name] = tmp[i].value;
                        }
                    }
                    
                    params['historia'] = tinyMCE.get('shistoria').getContent();
                    params['objetivo'] = tinyMCE.get('sobjetivo').getContent();
                    params['perfil'] = tinyMCE.get('sperfil').getContent();
                    params['desgraviacion'] = tinyMCE.get('sdesgraviacion').getContent();
                    
                    uget({
                        type: 'POST',
                        url: LinkServer.Url('socios', 'add', []),
                        data: params
                    }).done(function (json) {
                        if(json) {
                            if(json._code === 200) {
                                Socios.load();
                            } else {
                                alert(json._message + ". Verifique que todos los campos estan llenos y vuelva a guardar.");
                            }
                        }
                    });
                    
                    return false;
                });
            });

            /*Boton Level Up explorador*/
            $("#btn_up").click(function () {
                dir = dir.slice(0, -1);
                scandir();
            });

            /*Boton nueva carpeta*/
            $("#btn_new_folder").click(function () {
                new_folder();
            });

            /*Boton para subir archivo*/
            $("#btn_upload").click(function () {
                upload_file();
            });

            /*Seleccionar todo al hacer clic sobre el texto de info file*/
            $(document).on('click', '#explorer input', function () {
                $(this).select();
            });

            /*Iframe para subir archivo*/
            var str = "<form id='formfile' method='POST' action='" + LinkServer.Url('file', 'upload', []) + "' enctype='multipart/form-data'>"
                    + "<input type='file' name='file' id='inputfile' onchange='this.form.submit();' />"
                    + "<input type='text' name='dir' id='inputname' />"
                    + "</form>";

            $("#loadfile").contents().find("body").html(str);
            $("#loadfile").load(function () {
                var jstr = $("#loadfile").contents().find("body").text(),
                    json = JSON.parse(jstr);

                if(json._code !== 200) {
                    alert("Ocurrió un error al subir archivo.");
                }

                setTimeout(function () {
                    $("#loadfile").contents().find("body").html(str);
                    scandir();
                }, 150);
            });
        </script>
	</body>
</html>
