@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="#">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Dashboard
                        </li>
                    </ol>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            @if (Auth::user()->employee)
                <div align="center">
                    <video id="preview" width="400" height="200" autoplay muted></video>
                </div>

                <div align="center">

                    @php
                        $id = Auth::guard('web')->user()->id;
                    @endphp

                    <a href="/employee/user-status-active/{{ $id }}" target="_block" class="btnCustom btnGreen"
                        id="startButton">
                        Start Working
                    </a>
                    <a href="/employee/user-status-block/{{ $id }}" target="_block" class="btnCustom btnRed"
                        id="stopButton">
                        Stop Working
                    </a>

                </div>
                <div align="center">
                    <br><br>
                    <p>Select entire screen option when sharing the screen so your activity can be monitored.</p>
                </div>
                <a id="screenshot-preview"></a>
                <script>
                    let monitor = false;
                    let preview = document.getElementById("preview");
                    let startButton = document.getElementById("startButton");
                    let stopButton = document.getElementById("stopButton");
                    stopButton.style.display = "none";

                    function stop(stream) {
                        stream.getTracks().forEach(track => track.stop());
                        monitor = false;
                    }

                    stopButton.addEventListener("click", function() {
                        monitor = false;
                        stop(preview.srcObject);
                        startButton.style.display = "block";
                        stopButton.style.display = "none";
                    });

                    startButton.addEventListener("click", function() {
                        monitor = true;
                        stopButton.style.display = "block";
                        startButton.style.display = "none";
                        navigator.mediaDevices.getDisplayMedia({
                            video: true,
                            audio: true
                        }).then(stream => {
                            preview.srcObject = stream;
                            preview.captureStream = preview.captureStream || preview.mozCaptureStream;
                            return new Promise(resolve => preview.onplaying = resolve);
                        })
                    }, false);

                    function takeSnapshot(video) {
                        var canvas = document.createElement('canvas');
                        canvas.width = video.videoWidth || video.clientWidth;
                        canvas.height = video.videoHeight || video.clientHeight;

                        var context = canvas.getContext('2d');
                        context.drawImage(video, 0, 0, canvas.width, canvas.height);

                        return canvas.toDataURL('image/png');
                    }

                    function snapAction() {
                        var screenVideo = document.getElementById('preview');
                        var screenShot = takeSnapshot(screenVideo);
                        console.log("value of monitoring " + monitor)
                        if (monitor) {
                            $.ajax({
                                type: "POST",
                                url: "{{ route('employees.store.screen') }}",
                                data: {
                                    screenShot: screenShot,
                                    id: {{ auth()->user()->id }}
                                }
                            }).done(function(o) {
                                console.log('saved');
                                // If you want the file to be visible in the browser
                                // - please modify the callback in javascript. All you
                                // need is to return the url to the file, you just saved
                                // and than put the image in your browser.
                            });
                            var btn = document.getElementById("screenshot-preview");
                            btn.href = screenShot;
                            btn.download = "screenShot";
                            //btn.click();
                        }
                        setTimeout(snapAction, 10000);
                    }
                    snapAction();
                    @endif
                </script>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- /.content-wrapper -->
@endsection
