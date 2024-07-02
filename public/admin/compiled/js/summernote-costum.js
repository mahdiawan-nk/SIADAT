class SummernoteCustom {
    constructor(options) {
        this.settings = Object.assign(
            {
                elementEditor: options.elementEditor || "#summernote-editor",
                heightEditor: options.heightEditor || "40vh",
            },
            options
        );
        this.init();
    }

    init() {
        this.initEditorSummernote();
    }

    initEditorSummernote() {
        const self = this; // Capture `this` context for use inside nested functions
        $(document).ready(function () {
            $(self.settings.elementEditor).summernote({
                height: self.settings.heightEditor,
                styleTags: [
                    "p",
                    {
                        title: "Blockquote",
                        tag: "blockquote",
                        className: "blockquote",
                        value: "blockquote",
                    },
                    "pre",
                    "h1",
                    "h2",
                    "h3",
                    "h4",
                    "h5",
                    "h6",
                ],
                toolbar: [
                    [
                        "style",
                        ["style", "bold", "italic", "underline", "clear"],
                    ],
                    ["font", ["strikethrough", "superscript", "subscript"]],
                    ["fontsize", ["fontsize"]],
                    ["color", ["color"]],
                    ["para", ["ul", "ol", "paragraph"]],
                    ["insert", ["myimage"]],
                    ["view", ["fullscreen", "codeview", "help"]],
                ],
                popover: {
                    image: [
                        [
                            "image",
                            [
                                "resizeFull",
                                "resizeHalf",
                                "resizeQuarter",
                                "resizeNone",
                            ],
                        ],
                        [
                            "float",
                            [
                                "floatLeft",
                                "floatRight",
                                "floatNone",
                                "floatCenter",
                            ],
                        ],
                        ["remove", ["removeMedia"]],
                    ],
                },
                buttons: {
                    myimage: SummernoteCustom.imageButton,
                    floatCenter: SummernoteCustom.floatCenter,
                    floatLeft: SummernoteCustom.floatLeft,
                    floatRight: SummernoteCustom.floatRight,
                    floatNone: SummernoteCustom.floatNone,
                },
            });
        });
    }

    static imageButton(context) {
        var ui = $.summernote.ui;
        var button = ui.button({
            contents: '<i class="note-icon-picture"></i>',
            tooltip: "Upload Image",
            click: function () {
                fileManager.setClickSummernote(true);
                fileManager.openBysummernote();
                fileManager.setMultipleSelect(false);
            },
        });

        return button.render();
    }

    static floatCenter(context) {
        var ui = $.summernote.ui;
        var button = ui.button({
            contents: '<i class="note-icon-align-center"></i>',
            tooltip: "Center",
            click: function () {
                SummernoteCustom.applyFloatStyle("center", this);
            },
        });

        return button.render();
    }

    static floatLeft(context) {
        var ui = $.summernote.ui;
        var button = ui.button({
            contents: '<i class="note-icon-align-left"></i>',
            tooltip: "Left",
            click: function () {
                SummernoteCustom.applyFloatStyle("left", this);
            },
        });

        return button.render();
    }

    static floatRight(context) {
        var ui = $.summernote.ui;
        var button = ui.button({
            contents: '<i class="note-icon-align-right"></i>',
            tooltip: "Right",
            click: function () {
                SummernoteCustom.applyFloatStyle("right", this);
            },
        });

        return button.render();
    }

    static floatNone(context) {
        var ui = $.summernote.ui;
        var button = ui.button({
            contents: '<i class="note-icon-rollback"></i>',
            tooltip: "Remove Float",
            click: function () {
                SummernoteCustom.applyFloatStyle("none", this);
            },
        });

        return button.render();
    }

    static applyFloatStyle(floatType, buttonContext) {
        var $img = $(buttonContext)
            .closest(".note-editor")
            .find(".note-editable")
            .children("p")
            .children("img");
        var imgStyle = $img.attr("style") || "";
        var cssObject = SummernoteCustom.parseCSS(imgStyle);
        console.log(cssObject);
        // Remove existing float properties
        cssObject.removeProperty("float");
        cssObject.removeProperty("display");
        cssObject.removeProperty("margin");
        var floatList = ["right", "left", "none"];
        if (floatList.includes(floatType)) {
            cssObject.setProperty("float", floatType);
        } else {
            cssObject.setProperty("display", "block");
            cssObject.setProperty("margin", "0 auto");
            cssObject.setProperty("float", "none");
        }

        $img.css(cssObject);
    }

    static parseCSS(cssString) {
        var cssObj = {};
        var properties = cssString.split(";").filter(Boolean);

        properties.forEach(function (property) {
            var parts = property.split(":").map(function (part) {
                return part.trim();
            });
            cssObj[parts[0]] = parts[1];
        });

        cssObj.setProperty = function (property, value) {
            this[property] = value;
        };

        cssObj.removeProperty = function (property) {
            delete this[property];
        };

        return cssObj;
    }
}
