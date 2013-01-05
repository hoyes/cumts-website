;(function(jQuery) {
    return jQuery.widget("IKS.hallocustomimage", {
        options: {
            editable: null,
            toolbar: null,
            uuid: "",
            limit: 8,
            loaded: null,
            upload: null,
            uploadUrl: null,
            dialogOpts: {
                autoOpen: false,
                width: 270,
                height: "auto",
                title: "Insert Image",
                modal: false,
                resizable: false,
                draggable: true,
                dialogClass: 'halloimage-dialog'
            },
            dialog: null,
            buttonCssClass: null,
            entity: null,
            vie: null,
            dbPediaUrl: "http://dev.iks-project.eu/stanbolfull",
            maxWidth: 250,
            maxHeight: 250,
            sessionId: ''
        },
        populateToolbar: function(toolbar) {
            var buttonHolder, buttonset, dialogId, id, tabContent, tabs, widget;
            this.options.toolbar = toolbar;
            widget = this;
            dialogId = "" + this.options.uuid + "-image-dialog";
            this.options.dialog = $("<div id=\"" + dialogId + "\"></div>");

            this._addGuiTabUpload(this.options.dialog);

            $(this.options.dialog).append(this.current);
            buttonset = jQuery("<span class=\"" + widget.widgetName + "\"></span>");
            id = "" + this.options.uuid + "-image";
            buttonHolder = jQuery('<span></span>');
            buttonHolder.hallobutton({
                label: 'Images',
                icon: 'icon-picture',
                editable: this.options.editable,
                command: null,
                queryState: false,
                uuid: this.options.uuid,
                cssClass: this.options.buttonCssClass
            });
            buttonset.append(buttonHolder);
            this.button = buttonHolder;
            this.button.on("click", function(event) {
                if (widget.options.dialog.dialog("isOpen")) {
                    widget._closeDialog();
                } else {
                    widget._openDialog();
                    widget.lastSelection = widget.options.editable.getSelection()
                }
                return false;
            });
            this.options.editable.element.on("hallodeactivated", function(event) {
                return widget._closeDialog();
            });
            jQuery(this.options.editable.element).delegate("img", "click", function(event) {
                return widget._openDialog();
            });
            toolbar.append(buttonset);
            this.options.dialog.dialog(this.options.dialogOpts);
        },
        setCurrent: function(image) {
            return this.current.halloimagecurrent('setImage', image);
        },
        _openDialog: function() {
            var cleanUp, editableEl, getActive, suggestionSelector, toolbarEl, widget, xposition, yposition,
                _this = this;
            widget = this;


            editableEl = jQuery(this.options.editable.element);
            toolbarEl = jQuery(this.options.toolbar);
            xposition = editableEl.offset().left + editableEl.outerWidth() - 3;
            yposition = toolbarEl.offset().top + toolbarEl.outerHeight() + 29;
            yposition -= jQuery(document).scrollTop();
            this.options.dialog.dialog("option", "position", [xposition, yposition]);

            widget.options.loaded = 1;
            this.options.editable.keepActivated(true);
            this.options.dialog.on('dialogopen', function() {
                url = Routing.generate('hoyes_image_manager_post', {}, true);

                widget.options.dialog.find('input[type=file]').uploadify({
                    swf  : '/bundles/hoyesimagemanager/uploadify.swf',
                    uploader    : url,
                    cancelImg : '/bundles/hoyesimagemanager/images/cancel.png',
                    formData   : {
                        _uploadify : true,
                        _sessionid : widget.options.sessionId,
                        width: 200,
                        height: 180
                    },
                    fileTypeDesc: 'All Images',
                    fileTypeExts: '*.png;*.jpg;*.jpeg;*.gif',
                    buttonText: 'Select Image File',
                    multi: false,
                    auto      : true,
                    onUploadSuccess  : function(file, data) {
                        console.log(data);
                        response = $.parseJSON(data);
                        var img = $('<img/>').attr('src', response.url)
                            .attr('width', response.width).attr('height', response.height);
                        var anchor = $('<a/>').attr('href', response.full_url)
                            .addClass('fancybox left').html(img);
console.log($(widget.options.dialog).find('#dialog-preview').length);
                        $(widget.options.dialog).find('#dialog-preview').html(anchor);
                    }
                });
            })
            this.options.dialog.dialog("open");
            this.options.dialog.on('dialogclose', function() {
                jQuery('label', _this.button).removeClass('ui-state-active');
                _this.options.editable.element.focus();
                return _this.options.editable.keepActivated(false);
            });
        },
        _closeDialog: function() {
            return this.options.dialog.dialog("close");
        },
        _addGuiTabUpload: function(element) {
            var content = $('<div/>');
            content.append($('<input/>').attr({type:'file', id: this.options.uuid+'-upload-dialog'}));
            content.append($('<div/>').attr('id', 'dialog-preview'));
            var style = {padding: '2px', border: '1px solid black'};

            var width = $('<p/>');
            width.append($('<label/>').attr('for', 'dialog_width').text('Width'))
            width.append($('<input/>').attr({'id': 'dialog_width', 'type': 'text'}).val(250).css(style));
            var height = $('<p/>');
            height.append($('<label/>').attr('for', 'dialog_height').text('Height'))
            height.append($('<input/>').attr({'id': 'dialog_height', 'type': 'text'}).val(200).css(style));
            content.append(width).append(height);

            var self = this;

            $('<button/>').text('Add').addClass('submit').click(function() {
                var html = self.options.dialog.find('#dialog-preview').html();

                self.options.editable.restoreSelection(self.lastSelection)
                document.execCommand("insertHtml", null, html)
                self.options.editable.element.trigger('change')
                self.options.editable.removeAllSelections()
                self._closeDialog()

                return false;
            }).appendTo(content);

            element.append(content);
        }
        /*
         insertImage = () ->
         # This may need to insert an image that does not have the same URL as
         # the preview image, since it may be a different size
         # Check if we have a selection and fall back to @lastSelection otherwise
         try
         if not widget.options.editable.getSelection()
         throw new Error "SelectionNotSet"
         catch error
         widget.options.editable.restoreSelection(widget.lastSelection)

         document.execCommand "insertImage", null, jQuery(this).attr('src')
         img = document.getSelection().anchorNode.firstChild
         jQuery(img).attr "alt", jQuery(".caption").value

         triggerModified = () ->
         widget.element.trigger "hallomodified"
         window.setTimeout triggerModified, 100
         widget._closeDialog()

         addImage = "##{widget.options.uuid}-#{widget.widgetName-addimage"
         @options.dialog.find(".halloimage-activeImage, addImage).click insertImage
         */
    });
})(jQuery);