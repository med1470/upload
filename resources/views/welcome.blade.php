<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
          integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


</head>
<script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
<script src="https://mozilla.github.io/pdf.js/build/pdf.worker.js"></script>
<script src="https://requirejs.org/docs/release/2.3.5/minified/require.js"></script>
<script>
    window.onload = function () {
        document.querySelector("#pdf-upload").addEventListener("change", function (e) {
            var canvasElement = document.querySelector("canvas")
            var file = e.target.files[0]
            if (file.type != "application/pdf") {
                console.error(file.name, "is not a pdf file.")
                return
            }
            if (typeof require === 'function') {
                try {
                    PDFJS = require('../build/pdf.js');
                }
                    // when require fails, we do the right thing
                catch (e) {
                    PDFJS = window['pdfjs-dist/build/pdf'];
                }
            } else {
                PDFJS = window['pdfjs-dist/build/pdf'];
            }
            var fileReader = new FileReader();

            fileReader.onload = function () {
                var typedarray = new Uint8Array(this.result);

                PDFJS.getDocument(typedarray).then(function (pdf) {
                    // you can now use *pdf* here
                    console.log("the pdf has ", pdf.numPages, "page(s).")
                    pdf.getPage(pdf.numPages).then(function (page) {
                        // you can now use *page* here
                        var viewport = page.getViewport(2.0);
                        var canvas = document.querySelector("canvas")
                        canvas.height = viewport.height;
                        canvas.width = viewport.width;


                        page.render({
                            canvasContext: canvas.getContext('2d'),
                            viewport: viewport
                        });
                    });

                });
            };

            fileReader.readAsArrayBuffer(file);
        })
    }
</script>
<body>
<div class="container">
    <div class="row">
        <img style="margin-top: 40px" src="https://cdn-images-1.medium.com/max/1369/1*PPud-Z83-82NSwvzV9dnlg.png">
        <h2 style="text-align: center ; color: #1f6fb2 ; font-family: 'Noto Sans CJK JP Black'">Simplest file
            upload</h2>
        <h3 style="text-align: center ; color: forestgreen ; font-family: 'Noto Sans CJK JP Black'">Upload only PDF
            file</h3>
        <hr>

        @if ($testTable == true)
            <div class="col-md-offset-1 col-md-10">


                <table style="width:100%" class="table">
                    <h3 style="text-align: center ; color: #1f6fb2 ; font-family: 'Noto Sans CJK JP Black'">list of
                        imported files</h3>

                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">FileName</th>
                        <th scope="col">View</th>

                    </tr>
                    </thead>
                    @for ($j = 1; $j < $i; $j++)
                        <tr>
                            <th scope="row">{{ $j }}<br></th>
                            <td>{{ $array[$j] }}<br></td>
                            <td><a href="{{ $array[$j] }}">
                                    <button style="height: 30px ; width: 50px ; margin-top: 0px  "
                                            class="btn btn-danger"><i class="fas fa-eye"></i></button>
                                </a><br></td>

                        </tr>
                    @endfor
                </table>


            </div>
            <hr>
        @endif
        <div style="margin-top: 20px" class="col-md-offset-1 col-md-10">
            <h3 style="text-align: center ; color: #1f6fb2 ; font-family: 'Noto Sans CJK JP Black'">display a pdf
                file</h3>
            <div id="wrapper">
                <input class="btn btn-primary" type="file" id="pdf-upload"/>
            </div>
        </div>

        <hr>
        <div style="margin-top: 20px" class="col-md-offset-1 col-md-10" id="app">
            <h3 style="text-align: center ; color: #1f6fb2 ; font-family: 'Noto Sans CJK JP Black'">upload a pdf
                file</h3>

            <upload></upload>

        </div>
        <canvas class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2"></canvas>


    </div>
</div>


<script src="{{asset('js/app.js')}}"></script>
</body>
<style>
    #app {
        text-align: center;
    }

    img {
        width: 30%;
        margin: auto;
        display: block;
        margin-bottom: 10px;
    }

    button {

    }

    body {
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        font-size: 14px;
        line-height: 1.42857143;
        color: #333;
        background-color: #fff;
        background-image: url(https://www.filedropper.com/images/headerback.png);
        background-repeat: repeat-x;

    }

    #wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    button {
        height: 20px;
        position: relative;
        margin: -20px -50px;
        width: 100px;
        top: 50%;
        left: 50%;
    }
</style>
</html>
