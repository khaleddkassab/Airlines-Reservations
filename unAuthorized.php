<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UnAuthorized</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }

        .loader {
            font-size: 3em;
        }

        .U,
        .n,
        .A,
        .u,
        .t,
        .h,
        .o,
        .r,
        .i,
        .z,
        .e,
        .d {
            color: black;
            opacity: 0;
            animation: unauthorizedAnimation 2s ease-in-out infinite;
            letter-spacing: 0.5em;
            text-shadow: 2px 2px 3px #919191;
        }

        @keyframes unauthorizedAnimation {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }
        }
    </style>
</head>

<body>
    <div class="loader">
        <span class="U">U</span>
        <span class="n">n</span>
        <span class="A">A</span>
        <span class="u">u</span>
        <span class="t">t</span>
        <span class="h">h</span>
        <span class="o">o</span>
        <span class="r">r</span>
        <span class="i">i</span>
        <span class="z">z</span>
        <span class="e">e</span>
        <span class="d">d</span>
        <span class="!">!</span>

    </div>
</body>

</html>