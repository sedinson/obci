uget = function(params) {
    return $.ajax({
        type: (params.type) ? params.type : 'GET',
        url: (params.url) ? params.url : '',
        data: (params.data) ? params.data : {},
        xhrFields: {
            withCredentials: true
        },
        crossDomain: true
    });
};

function Grafica4(container,pais,indicador,ano){
    var _this = this;
    
    this.organizar_json_balanza = function(data,nombre)
    {
        var myObject = [];
        var valor, datos = [];
        for(var i = 0; i < data._response.length; i++)
        {
            valor.push(parseFloat(data._response[i].valor1));
            valor.push(parseFloat(data._response[i].valor2));
            datos.push(valor);
            valor.splice(0,valor.length);
        }
        myObject.push({
            data: datos
        });
        return myObject;
    };
    
    this.graficarPuntos = function(container,datos,title,name_ejey,años) {

        $(function () {
        $(container).highcharts({
            chart: {
                type: 'scatter',
                zoomType: 'xy'
            },
            title: {
                text: 'Height Versus Weight of 507 Individuals by Gender'
            },
            subtitle: {
                text: 'Source: Heinz  2003'
            },
            xAxis: {
                title: {
                    enabled: true,
                    text: 'Height (cm)'
                },
                startOnTick: true,
                endOnTick: true,
                showLastLabel: true
            },
            yAxis: {
                title: {
                    text: 'Weight (kg)'
                }
            },
            legend: {
                layout: 'vertical',
                align: 'left',
                verticalAlign: 'top',
                x: 100,
                y: 70,
                maxHeight: 60,
                floating: true,
                backgroundColor: '#FFFFFF',
                borderWidth: 1
            },
            plotOptions: {
                scatter: {
                    marker: {
                        radius: 5,
                        states: {
                            hover: {
                                enabled: true,
                                lineColor: 'rgb(100,100,100)'
                            }
                        }
                    },
                    states: {
                        hover: {
                            marker: {
                                enabled: false
                            }
                        }
                    },
                    tooltip: {
                        headerFormat: '<b>{series.name}</b><br>',
                        pointFormat: '{point.x} cm, {point.y} kg'
                    }
                }
            },
            series: [{
                name: 'Female',
                data: [[161.2, 51.6], [167.5, 59.0], [159.5, 49.2], [157.0, 63.0], [155.8, 53.6],
                    [170.0, 59.0], [159.1, 47.6], [166.0, 69.8], [176.2, 66.8], [160.2, 75.2],
                    [172.5, 55.2], [170.9, 54.2], [172.9, 62.5], [153.4, 42.0], [160.0, 50.0]]
    
            }]
        });
    });

    };
    
    this.cargar_data = function(data)
    {
        if(data._code === 200)
        {
            var nombre = [];
            var myObject = [];
            
            myObject.push(_this.organizar_json_balanza()(data,nombre));
            console.log(myObject);

            var datos_grafica1,datos_grafica2 = [];

            for(var j = 0; j < myObject.length; j++){
                console.log(myObject[j]);
                datos_grafica1[j] = {
                    data : myObject[j][0].data
                };
                
                //datos_grafica[j] = myObject[j][0].data;// otra opcion
            }
            
            for(var j = 0; j < myObject.length; j++){
                console.log(myObject[j]);
                datos_grafica2[j] = myObject[j][0].data;// otra opcion
            }

            console.log(datos_grafica1);
            console.log(datos_grafica2);

            _this.graficarPuntos(container,datos_grafica,'TITLE','name_ejey',ano);
        }
    };
    
    uget({
             type: 'GET',
             url: LinkServer.Url('grafica', indicador, {
                 pais: pais ,
                 ano:ano
                 
             })
         }).done(function (data){
             console.log(data._response);
             _this.cargar_data(data);
     });

}


