// imports all needed fonts
function importFonts(fonts) {
    fonts.forEach(url => {
        var link = document.createElement('link');
        link.setAttribute('rel', 'preload');
        link.setAttribute('href', url);
        document.head.appendChild(link);
    });
}

// main funcions, gets called to generate canvas
function generateImage(data) {
    id = data.id;
    var stage = new Konva.Stage({
        container: id,
        width: data.width * 0.333,
        height: data.height * 0.333
    });

    var layer = new Konva.Layer();

    drawBackground(id, stage, layer, data, drawContent);
}

// draws all shapes
function drawContent(id, stage, layer, data) {


    if (data.rects) {
        data.rects.forEach(function (item) {
            drawRect(layer, item.attrs);
        });
    }

    if (data.texts) {
        data.texts.forEach(function (item) {
            drawText(layer, item.attrs, item.maxHeight, item.inputId);
        });
    }
    if (data.labels) {
        data.labels.forEach(function (item) {
            drawLabel(layer, item.attrsLabel, item.attrsText, item.maxHeight, item.inputId);
        });
    }
    stage.add(layer);
    stage.scale({ x: 0.333, y: 0.333 });
    setTimeout(function () {
        console.log('draw');
        layer.draw();
    }, 100);

    // download button action
    document.getElementById(data.inputs.genImage).addEventListener(
        'click',
        function () {
            var dataURL = stage.toDataURL({
                pixelRatio: 3
            });
            downloadURI(dataURL, 'stage.png');
        },
        false
    );
}

// draws the background --> image
function drawBackground(id, stage, layer, data, callback) {
    var image = new Image();

    const widthRatio = data.width / data['imageWidth'];
    const heightRatio = data.height / data['imageHeight'];

    var ratio = widthRatio > heightRatio ? widthRatio : heightRatio;

    image.onload = function () {
        var background = new Konva.Image({
            x: 0,
            y: 0,
            blurRadius: data['blurRadius'],
            image: image,
            width: data['imageWidth'] * ratio,
            height: data['imageHeight'] * ratio,

        });
        background.cache();
        background.filters([Konva.Filters.Blur]);
        layer.add(background);
        layer.batchDraw();
        callback(id, stage, layer, data);

    };
    image.src = data.img;

    return layer;
}

// Rect in which the text is placed
function drawRect(layer, attrs) {
    var rect = new Konva.Rect(attrs);
    // add the shape to the layer
    layer.add(rect);

    return layer;
}

// draws text according to data
function drawText(layer, attrs, maxHeight, inputId = -1) {
    var complexText = new Konva.Text(attrs);
    // scale text if it's too big
    scaleText(complexText, maxHeight, attrs.fontSize, 10);
    layer.add(complexText);
    // input for dynamic update
    if (inputId !== -1) {
        document.getElementById(inputId).addEventListener(
            'keydown',
            function (event) {
                complexText.text(event.target.value);
                scaleText(complexText, maxHeight, attrs.fontSize, 10);
                layer.draw();
            },
            false
        );
    }
}

// draws text according to data
function drawLabel(layer, attrsLabel, attrsText, maxHeight, inputId = -1) {

    var label = new Konva.Label(attrsLabel);
    label.add(new Konva.Tag({ fill: attrsLabel.fill }));

    var complexText = new Konva.Text(attrsText);
    label.add(complexText);
    // scale text if it's too big
    scaleText(complexText, maxHeight, attrsText.fontSize, 10);
    layer.add(label);
    // input for dynamic update
    if (inputId !== -1) {
        document.getElementById(inputId).addEventListener(
            'keyup',
            function (event) {
                complexText.text(event.target.value);
                scaleText(complexText, maxHeight, attrsText.fontSize, 10);
                layer.draw();
            },
            false
        );
    }
}

// creates download uri for png
function downloadURI(uri, name) {
    var link = document.createElement('a');
    link.download = name;
    link.href = uri;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    delete link;
}

// scales the text to fit space
function scaleText(text, maxHeight, fontSize, minFontSize) {

    if (text.height() > maxHeight) {
        while (text.height() > maxHeight && text.fontSize() > minFontSize) {
            text.fontSize(text.fontSize() - 1);
        }
    }
    else if (text.fontSize() != fontSize) {
        while (text.height() < maxHeight && text.fontSize() < fontSize) {
            text.fontSize(text.fontSize() + 1);
        }
    }
}
