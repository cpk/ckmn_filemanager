(function () {

    var root = this;

    var MaDnh = function (obj) {
        if (obj instanceof MaDnh) {
            return obj;
        }
        if (!(this instanceof MaDnh)) {
            return new MaDnh(obj);
        }
    };
    root.MaDnh = MaDnh;
    var previousMaDnh = root.MaDnh;
    var __ = _;
    MaDnh.events = {};
    MaDnh.event_system_status = true;


    MaDnh.noConflict = function () {
        root.MaDnhApp = previousMaDnh;
        return this;
    };

    MaDnh.setUnderscore = function (underscore) {
        MaDnh.__ = underscore;
    };
    MaDnh.config = {
        'siteName': '',
        'spa_mode': false,
        'site_url': '',
        'debugMode': false,
        'base_request_path': '',
        'cur_url': '',
        'cur_title': ''
    };


    /********************************************************
     *  HELPER
     ********************************************************/
    MaDnh.Helper = {};

    MaDnh.Helper.toArray = function (value) {
        if (__.isArray(value)) {
            return value;
        }
        var result = [];
        result.push(value);
        return result;
    };

    /**
     * Băm đối tượng thành chuỗi, giống serialize của php
     * @param {type} mixed_value
     * @returns {String}
     */
    MaDnh.Helper.serialize = function (mixed_value) {
        var val, key, okey,
            ktype = '', vals = '', count = 0,
            _utf8Size = function (str) {
                var size = 0, i = 0, l = str.length, code = '';
                for (i = 0; i < l; i++) {
                    code = str.charCodeAt(i);
                    if (code < 0x0080) {
                        size += 1;
                    }
                    else if (code < 0x0800) {
                        size += 2;
                    }
                    else {
                        size += 3;
                    }
                }
                return size;
            },
            _getType = function (inp) {
                var match, key, cons, types, type = typeof inp;

                if (type === 'object' && !inp) {
                    return 'null';
                }
                if (type === 'object') {
                    if (!inp.constructor) {
                        return 'object';
                    }
                    cons = inp.constructor.toString();
                    match = cons.match(/(\w+)\(/);
                    if (match) {
                        cons = match[1].toLowerCase();
                    }
                    types = ['boolean', 'number', 'string', 'array'];
                    for (key in types) {
                        if (cons == types[key]) {
                            type = types[key];
                            break;
                        }
                    }
                }
                return type;
            },
            type = _getType(mixed_value);

        switch (type) {
            case 'function':
                val = '';
                break;
            case 'boolean':
                val = 'b:' + (mixed_value ? '1' : '0');
                break;
            case 'number':
                val = (Math.round(mixed_value) == mixed_value ? 'i' : 'd') + ':' + mixed_value;
                break;
            case 'string':
                val = 's:' + _utf8Size(mixed_value) + ':"' + mixed_value + '"';
                break;
            case 'array':
            case 'object':
                val = 'a';
                for (key in mixed_value) {
                    if (mixed_value.hasOwnProperty(key)) {
                        ktype = _getType(mixed_value[key]);
                        if (ktype === 'function') {
                            continue;
                        }

                        okey = (key.match(/^[0-9]+$/) ? parseInt(key, 10) : key);
                        vals += this.serialize(okey) + this.serialize(mixed_value[key]);
                        count++;
                    }
                }
                val += ':' + count + ':{' + vals + '}';
                break;
            case 'undefined':
            // Fall-through
            default:
                // if the JS object has a property which contains a null value, the string cannot be unserialized by PHP
                val = 'N';
                break;
        }
        if (type !== 'object' && type !== 'array') {
            val += ';';
        }
        return val;
    };


    MaDnh.Helper.randomItem = function (items) {
        return items[Math.floor(Math.random() * items.length)];
    };

    MaDnh.Helper.randomString = function (length, chars) {
        var result = '';
        if (!chars) {
            chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }
        for (var i = length; i > 0; --i) {
            result += chars[Math.round(Math.random() * (chars.length - 1))];
        }
        return result;
    };

    MaDnh.Helper.callFunctionDynamic = function (func, data) {
        if (!__.isUndefined(func)) {
            if (typeof func == 'string') {
                try {
                    return window[func](data);
                } catch (e) {
                    try {
                        return eval(func);
                    } catch (e) {
                        return false;
                    }
                }
            } else if (__.isFunction(func)) {
                try {
                    return func(data);
                } catch (e) {
                    return false;
                }
            } else if (__.isArray(func)) {
                var length = func.length;
                for (var i = 0; i < length; i++) {
                    arguments.callee(func[i], data);
                }
            }
        } else {
            return false;
        }
        return true;
    };


    /**
     * Kiểm tra có phải là JSON result của 1 quá trình xử lý
     *
     * @param data
     * @returns {boolean}
     */
    MaDnh.Helper.isSystemJSON = function (data) {
        if (data.hasOwnProperty('info')
            && data.hasOwnProperty('process_info')
            && data.hasOwnProperty('process_data')
            && data.hasOwnProperty('process_action')) {
            return data.info.json_provider == 'json_output' && data.info.system == 'FileManager'
        }
        return false;
    };

    MaDnh.Helper.isProcessResult = function (object) {
        return object instanceof MaDnh.ProcessResult;
    };


    MaDnh.Helper.clearInRange = function (variable, min, max) {
        return Math.max(min, Math.min(variable, max));
    };
    MaDnh.Helper.progressAjaxAction = function (data) {
        if (MaDnh.Helper.isProcessResult(data)) {
            var actions = data.getActions();
            var i;
            console.log(actions);
            for (i in actions) {
                console.log(actions[i]);
                MaDnh.Helper.callFunctionDynamic(actions[i], data);
            }
        }
    };

    MaDnh.Helper.setupObject = function (object, option, value) {
        if (!__.isObject(object)) {
            object = {};
        }
        if (!__.isUndefined(value)) {
            object[option] = value;
        } else if (__.isObject(option)) {
            object = __.extend({}, object, option);
        }
        return object;
    };


    MaDnh.Helper.alert = function (content, callback, option) {
        var default_option = {
            type: 'info'
        };
        option = __.extend({}, default_option, option);

        var func = function (info) {
            MaDnh.Helper.callFunctionDynamic(callback, info)
        };

        var dialog = new MaDnh.BootstrapDialog();
        dialog.option(option);

        var buttons = {
            close: {
                label: 'Đóng',
                type: 'info',
                handler: func,
                is_default: true
            }
        };

        dialog.content = content;
        dialog.type = option.type;
        __.each(buttons, function (btn_info, btn_name) {
            dialog.addButton(btn_name, btn_info);
        });
        dialog.show();
    };


    MaDnh.Helper.confirm = function (content, callback, option) {
        var default_option = {
            type: 'info',
            yes_label: 'Đồng ý',
            no_label: 'Không',

            default_button: 'no'
        };
        option = __.extend({}, default_option, option);

        var func = function (info) {
            var result = false;
            if (__.has(info, 'button_name')) {
                result = info['button_name'] == 'yes';
            }
            MaDnh.Helper.callFunctionDynamic(callback, result)
        };

        var dialog = new MaDnh.BootstrapDialog();
        dialog.option(option);

        var buttons = {
            yes: {
                label: option.yes_label,
                type: 'info',
                handler: func,
                is_default: false
            },
            no: {
                label: option.no_label,
                type: 'default',
                handler: func,
                is_default: false
            }
        };

        if (__.has(buttons, option.default_button)) {
            buttons[option.default_button].is_default = true;
        }

        dialog.content = content;
        dialog.type = option.type;
        __.each(buttons, function (btn_info, btn_name) {
            dialog.addButton(btn_name, btn_info);
        });
        dialog.show();
    };

    MaDnh.Helper.iframeDialog = function (url, option) {
        var default_option = {
            type: 'info',
            height: '300',
            title: 'Thông báo',
            size: 'lg',
            close_by_button: false
        };
        option = __.extend({}, default_option, option);
        var dialog = new MaDnh.BootstrapDialog();
        var buttons = {
            no: {
                label: 'Đóng',
                type: 'info',
                hide_modal: true
            }
        };

        dialog.option(option);


        dialog.content = '<iframe src="' + url + '" style="width:100%; height:' + option.height + 'px">';
        dialog.content += '<p>Trình duyệt không hỗ trợ iframes.</p>';
        dialog.content += '</iframe>';

        dialog.title = option.title;
        dialog.type = option.type;
        if (option.close_by_button) {
            __.each(buttons, function (btn_info, btn_name) {
                dialog.addButton(btn_name, btn_info);
            });
        }


        dialog.show();
    };

    MaDnh.Helper.formDialog = function (form_content, callback, option) {
        var default_option = {
            type: 'info',
            title: 'Nhập liệu',
            submit_label: 'Ok',
            close_label: 'Cancel'
        };
        option = __.extend({}, default_option, option);

        var func = function (info) {
            var result = false;
            if (__.has(info, 'button_name') && info['button_name'] == 'submit') {
                result = MaDnh.DOM.getFormInputValue('#' + info['modal_id'] + ' .modal-body');
            }
            MaDnh.Helper.callFunctionDynamic(callback, result)
        };

        var dialog = new MaDnh.BootstrapDialog();


        var buttons = {
            submit: {
                label: option.submit_label,
                type: 'info',
                handler: func,
                is_default: false,
                hide_modal: true,
                on_hide: true
            },
            close: {
                label: option.close_label,
                type: 'default',
                handler: func,
                is_default: true
            }
        };

        dialog.content = form_content;
        dialog.type = option.type;
        dialog.title = option.title;

        __.each(default_option, function (value, key) {
            delete option[key];
        });
        dialog.option(option);

        __.each(buttons, function (btn_info, btn_name) {
            dialog.addButton(btn_name, btn_info);
        });


        dialog.show();
    };


    /**
     * Prompt với 1 giá trị chuỗi
     * @param title
     * @param old_value
     * @param callback
     * @param option
     */
    MaDnh.Helper.prompt = function (title, old_value, callback, option) {
        var form = '<p>' + title + '</p>' + '<input class="form-control" name="prompt_data" type="text" value="' + __.escape(old_value) + '"/>';
        MaDnh.Helper.formDialog(form, function (result) {
            if (__.has(result, 'prompt_data')) {
                MaDnh.Helper.callFunctionDynamic(callback, result['prompt_data']);
            } else {
                MaDnh.Helper.callFunctionDynamic(callback, false);
            }
        }, option);

    };

    /**
     * Prompt với nhiều phần tử
     * @param contents
     * @param callback
     * @param option
     */
    MaDnh.Helper.prompts = function (contents, callback, option) {
        if (__.isUndefined(contents)) {
            contents = MaDnh.Helper.promptTextElement('prompt_data', '');
        }

        if (__.isArray(contents)) {
            contents = contents.join();
        }

        MaDnh.Helper.formDialog(contents, function (result) {
            MaDnh.Helper.callFunctionDynamic(callback, result);
        }, option);

    };

    /**
     * Tạo phần tử text element cho prompt
     * @param name Tên giá trị
     * @param title Tiêu đề
     * @param default_value Giá tị mặc định
     * @returns {string}
     */
    MaDnh.Helper.promptTextElement = function (name, title, default_value) {
        default_value = default_value || '';
        title = title || name;

        return '<p>' + title + '<br /><input type="text" name="' + __.escape(name) + '" value="' + __.escape(default_value) + '" /></p>';
    };

    /**
     * Tạo element cho prompt. Vd: MaDnh.Helper.promptCheckboxElement('checkbox_name', 'Tieu de', {a:'A', b:'B'})
     *
     * @param name
     * @param title
     * @param values
     * @returns {string}
     */
    MaDnh.Helper.promptCheckboxElement = function (name, title, values) {
        title = title || name;
        var checkbox_values = {};
        var content = '<p>' + title + '<br />';
        checkbox_values = __.extend({}, checkbox_values, values);

        __.each(checkbox_values, function (value, key) {
            content += '<label><input type="checkbox" name="' + __.escape(name) + '" value="' + __.escape(key) + '" /> ' + value + '</label><br />';
        });
        return content + '</p>';
    };


    /********************************************************
     *  DOM
     ********************************************************/
    MaDnh.DOM = {};

    MaDnh.DOM.disableElement = function (selector) {
        $(selector).attr('disabled', 'disabled');
    };
    MaDnh.DOM.enableElement = function (selector) {
        $(selector).removeAttr('disabled');
    };

    MaDnh.DOM.getSelectOptions = function (selector, values) {
        var select = $(selector);

        if (__.isArray(values)) {
            values = __.map(values, function (value) {
                return 'option[value="' + value + '"]';
            });
            return select.find(values.join(', '));
        }
        return select.find('option[value="' + values + '"]');
    };
    MaDnh.DOM.selectValue = function (selector, values) {
        var options = this.getSelectOptions(selector, values);
        __.each(options, function (e) {
            e.prop('selected', true);
        });
    };

    MaDnh.DOM.selectUnselectValue = function (selector, values) {
        var options = this.getSelectOptions(selector, values);
        __.each(options, function (e) {
            e.prop('selected', false);
        });
    };

    MaDnh.DOM.selectRemoveOption = function (selector, values) {
        var options = this.getSelectOptions(selector, values);
        options.remove();
    };

    MaDnh.DOM.selectDesableOption = function (selector, values) {
        var options = this.getSelectOptions(selector, values);
        __.each(options, function (e) {
            e.attr('disabled', 'disabled');
        });
    };
    MaDnh.DOM.selectEnableOption = function (selector, values) {
        var options = this.getSelectOptions(selector, values);
        __.each(options, function (e) {
            e.removeAttr('disabled');
        });
    };
    MaDnh.DOM.checkRadio = function (radio_name, value) {
        $("input:radio[name='" + radio_name + "']:checked").prop('checked', false);
        $("input:radio[name='" + radio_name + "'][value=" + value + "]").prop('checked', true);
    };
    MaDnh.DOM.getRadioValue = function (radio_name) {
        return $("input:radio[name ='" + radio_name + "']:checked").val();
    };


    MaDnh.DOM.setCheckBoxStatus = function (selector, status) {
        $(selector).prop('checked', status);
    };

    MaDnh.DOM.setTableCheckboxsStatus = function toggleCheckboxs(table_selector, status) {
        var check_status = status ? ':not(:checked)' : ':checked';
        var checkboxs = $(table_selector + ' tr td input:checkbox' + check_status);
        console.log('Check status', check_status);
        checkboxs.each(function (index, el) {
            $(el).prop('checked', status).trigger('change');
        });
    };


    /**
     * Lấy dữ liệu các input trong form và trả về dạng <<ten input>> => <<gia tri>>
     * @param {string} form_selector
     * @returns {{}}
     */
    MaDnh.DOM.getFormInputValue = function (form_selector) {
        var form = $(form_selector);
        var formElements = form.find('input:not(input[type="radio"]), textarea, select, input[type="radio"]:checked');
        var result = {}, tmpElement, i, len;
        for (i = 0, len = formElements.length; i < len; i++) {
            tmpElement = $(formElements[i]);
            if (tmpElement.attr('type') === 'checkbox') {
                var checkboxName = tmpElement.attr('name');
                var checkBoxValue = tmpElement.is(':checked') ? (tmpElement.val() ? tmpElement.val() : 'on') : 'off';

                if (form.find('input[type="checkbox"][name="' + checkboxName + '"]').length > 1) {
                    if (tmpElement.is(':checked')) {
                        if (__.isUndefined(result[checkboxName])) {
                            result[checkboxName] = [];
                        }
                        result[checkboxName].push(checkBoxValue);
                    }

                } else {
                    result[checkboxName] = checkBoxValue;
                }


            } else {
                if (tmpElement.attr('name')) {
                    result[tmpElement.attr('name')] = tmpElement.val();
                }
            }

        }
        return result;
    };


    /**
     * Gán dữ liệu vào form
     * @param form
     * @param data
     * @param prefix
     * @returns {boolean}
     */
    MaDnh.DOM.assignFormData = function (form, data, prefix) {

        if (!__.isString(prefix) || __.isEmpty(prefix)) {
            prefix = "";
        }
        if (typeof form == 'string') {
            form = $(form);
        }
        if (form.length < 1) {
            return false;
        }
        for (var prop in data) {
            if (data.hasOwnProperty(prop) && form.find('*[name="' + prefix + prop + '"]').length) {
                var $this = form.find('*[name="' + prefix + prop + '"]').first();
                if ($this.is('input') || $this.is('textarea')) {
                    if ($this.is(':radio') && [false, 'off', '', 0, '0'].indexOf(data[prop]) == -1) {
                        $this = form.find('*[name="' + prefix + prop + '"][value="' + data[prop] + '"]').first();
                        $this.attr('checked', 'checked');
                    } else if ($this.is(':checkbox') && [false, 'off', '', 0, '0'].indexOf(data[prop]) == -1) {
                        $this.attr('checked', 'checked');
                    } else {
                        $this.val(data[prop]);
                    }
                } else if ($this.is('select')) {
                    $this.find('option').removeAttr('selected');
                    if (__.isArray(data[prop])) {
                        //Multi select
                        var i, l;
                        for (i = 0, l = data[prop].length; i < l; i++) {
                            $this.find('option[value="' + data[prop][i] + '"]').first().attr('selected', 'selected');
                        }

                    } else {
                        //Select basic
                        $this.find('option[value="' + data[prop] + '"]').first().attr('selected', 'selected');

                    }

                } else if ($this.is('a, button')) {
                    $this.html(data[prop]);
                }

            }
        }
        return true;
    };


    /********************************************************
     *  TEMPLATE
     ********************************************************/
    MaDnh.Template = {
        compiled: {},
        templated: {}
    };


    /**
     * Compile 1 handlebars templates
     * @param {type} templateName   Tên của templates
     * @param {type} content    Nội dung của templates, dùng jquery để lấy nội dung
     * @returns {undefined}
     */
    MaDnh.Template.setTemplate = function (templateName, content) {
        if (window.Handlebars) {
            MaDnh.Template.compiled[templateName] = Handlebars.compile(content);
        }
    };


    /**
     * Compiled tất cả các templates handlebars trong page <br />
     * Các handlebars templates phải có ID bắt đầu bằng 'template_' và thuộc tính TYPE là 'text/x-handlebars-templates'
     * @returns {undefined}
     */
    MaDnh.Template.compileAll = function ($source) {
        if (__.isUndefined($source)) {
            $source = $('html');
        }
        var tmp = $source.find('script[id^=template_]');
        var tmpElement = '';

        tmp.each(function (i, el) {
            tmpElement = $(el);
            MaDnh.Template.setTemplate(tmpElement.attr('id').replace('template_', ''), tmpElement.html());
        });
        return tmp.length;
    };


    /**
     * Kiểm tra có 1 handlebars templates đã compile không
     * @param templateName Tên templates
     * @returns {boolean}
     */
    MaDnh.Template.hasTemplate = function (templateName) {
        return !__.isUndefined(MaDnh.Template.compiled[templateName]);
    };

    /**
     * Tạo ra templates từ 1 Handlebars templates compiled
     * @param {String} templateName   Tên của handlebars templates compiled
     * @param {Object} data   Các giá trị cần ánh xạ vào templates, là dạng đối tượng, vd: {a:'A', b:'B'}
     * @returns {String}    Template đã được ánh xạ giá trị
     */
    MaDnh.Template.render = function (templateName, data) {
        if (MaDnh.Template.hasTemplate(templateName)) {
            return MaDnh.Template.compiled[templateName](__.extend({}, data));
        }
        return false;
    };

    /**
     * Thêm 1 templates đã ánh xạ vào biến lưu trữ để có thể dùng lại nhiều lần
     * @param {type} templateName   Tên templates
     * @param {type} templateContent    Nội dung templates đã được ánh xạ
     * @returns {undefined}
     */
    MaDnh.Template.addTemplated = function (templateName, templateContent) {
        MaDnh.Template.templated[templateName] = templateContent;
    };

    /**
     * Kiểm tra trong biến lưu trữ chung có 1 templates nào chưa
     * @param {String} templateName
     * @returns {Boolean}
     */
    MaDnh.Template.hasTemplated = function (templateName) {
        return !__.isUndefined(MaDnh.Template.templated[templateName]);
    };

    /**
     * Lấy ra 1 templates đã thêm vào biến lưu trữ chung
     * @param {String} templateName   Tên templates đã thêm
     * @returns {*} Trả về nội dung của templates cần lấy, <b>FALSE</b> nếu templates cần lấy chưa được thêm vào biến lưu trữ chung
     */
    MaDnh.Template.renderTemplated = function (templateName) {
        if (MaDnh.Template.hasTemplated(templateName)) {
            return false;
        }
        return MaDnh.Template.templated[templateName];
    };


    /**
     * Tạo các element
     * Thông tin về thẻ, các giá trị cần phải có: _name - xác định loại thẻ (div, a, p,...); _text - nội dung text của thẻ; _html - nội dung dạng html của thẻ.
     * Nếu là thẻ dạng select, input,... thì cần phải có thuộc tính <b>value</b>, tùy vào loại thẻ mà value là dạng chuỗi hay mảng (select). Nếu thẻ là <b>select</b> thì giá trị value sẽ có dạng: [{value:'giá trị của option', text:'Chuỗi sẽ hiển thị của option này'},...]
     * vd: a=createElement({_name:'div', class:'navbar navbar-fixed', style:'height:100px; width:100%; background: red', _text:'hu<b>hu</b>',_html:'ha<b>ha</b>'});
     *a1=createElement({_name:'optgroup', label:'Nhom 1', value:[createElement({value:'giaTri1',_html:'Giá trị 1', _name:'option'}),createElement({value:'giaTri2',_html:'Giá trị 2', _name:'option'}),createElement({value:'giaTri4',_html:'Giá trị 4', _name:'option'})]});
     *a2=createElement({_name:'optgroup', label:'Nhom 1', value:[createElement({value:'giaTri1',_html:'Giá trị 1', _name:'option'}),createElement({value:'giaTri2',_html:'Giá trị 2', _name:'option'}),createElement({value:'giaTri4',_html:'Giá trị 4', _name:'option'})]});
     *a3=createElement({_name:'optgroup', label:'Nhom 1', value:[createElement({value:'giaTri1',_html:'Giá trị 1', _name:'option'}),createElement({value:'giaTri2',_html:'Giá trị 2', _name:'option'}),createElement({value:'giaTri4',_html:'Giá trị 4', _name:'option'})]});
     *
     *a.append(createElement({_name:'select',value:[a1, a2,a3]}));
     *$('body').append(a)
     *
     * @param data
     * @returns {*}
     */
    MaDnh.Template.createElement = function (data) {
        if (__.isUndefined(data._name)) {
            return '';
        }
        var element = $('<' + data._name + '>');
        var elementText = data._text || '';
        var elementHtml = data._html || '';

        if (elementText) {
            element.text(elementText);
        }
        if (elementHtml) {
            element.html(elementHtml);
        }


        if ((data._name == 'select' || data._name == 'optgroup') && !__.isUndefined(data.value) && __.isArray(data.value)) {

            for (var i = 0, l = data.value.length; i < l, __.isObject(data.value[i]); i++) {
                element.append(data.value[i]);
            }
            data.value = undefined;
        }

        data._name = undefined;
        data._text = undefined;
        data._html = undefined;

        element.attr(data);
        return element;
    };

    MaDnh.Template.bootstrapColorType = function (type) {
        var types = {
            info: 'info',
            clean: 'info',
            primary: 'primary',
            success: 'success',
            warning: 'warning',
            danger: 'danger',
            error: 'danger'
        };
        if (!__.has(types, type)) {
            type = 'info';
        }
        return __.property(type)(types);
    };

    MaDnh.Template.bootstrapAlert = function (content, type) {
        return '<div class="alert alert-' + MaDnh.Template.bootstrapColorType(type) + ' square fade in">' + content + '</div>'
    };
    MaDnh.Template.getAjaxAlertContent = function (result) {
        var contents = '';
        if (MaDnh.Helper.isProcessResult(result)) {
            __.each(result.getInfos(), function (info_obj) {
                contents += MaDnh.Template.bootstrapAlert(info_obj.content, info_obj.type);
            });
        }
        return contents;
    };

    MaDnh.Template.alertAjaxResult = function (result, callback) {
        var content = this.getAjaxAlertContent(result);
        if (content) {
            MaDnh.Helper.alert(content, callback);
        } else {
            MaDnh.Helper.callFunctionDynamic(callback);
        }
    };


    MaDnh.cleanEvents = function (confirm) {
        if (confirm === true) {
            MaDnh.events = {};
        }
    };

    MaDnh.eventStatus = function (status) {
        if (__.isUndefined(status)) {
            return true && MaDnh.event_system_status;
        }
        MaDnh.event_system_status = true && status;
    };

    MaDnh.hasEvent = function (event) {
        return !__.isUndefined(event) && !__.isUndefined(MaDnh.events[event]);
    };

    MaDnh.bindEvent = function (event, callback, priority) {
        if (!__.isArray(event)) {
            if (__.isObject(event)) {
                event = __.values(event);
            } else {
                event = [event];
            }
        }

        __.each(event, function (event_name) {
            if (!MaDnh.hasEvent(event_name)) {
                MaDnh.events[event_name] = new MaDnh.Priority();
            }
            MaDnh.events[event_name].addContent(callback, priority);
        });
    };
    MaDnh.bindEventUnique = function (event, callback, priority) {
        if (!__.isArray(event)) {
            if (__.isObject(event)) {
                event = __.values(event);
            } else {
                event = [event];
            }
        }
        __.each(event, function (event_name) {
            if (!MaDnh.hasEvent(event_name)) {
                MaDnh.events[event_name] = new MaDnh.Priority();
                MaDnh.events[event_name].addContent(callback, priority);
            } else if (!MaDnh.events[event_name].hasContent(callback)) {
                MaDnh.events[event_name].addContent(callback, priority);
            }
        });

    };


    MaDnh.unBindEvent = function (event, callback) {
        if (!__.isArray(event)) {
            if (__.isObject(event)) {
                event = __.values(event);
            } else {
                event = [event];
            }
        }
        __.each(event, function (event_name) {
            if (MaDnh.hasEvent(event_name)) {
                if (__.isUndefined(callback)) {
                    delete MaDnh.events[event_name];
                } else {
                    MaDnh.events[event_name].removeContent(callback);
                }
            }
        });
    };
    MaDnh.triggerEvent = function (event, data) {
        if (!MaDnh.eventStatus() || __.isUndefined(event) || __.isUndefined(MaDnh.events[event])) {
            return false;
        }
        var callbacks = MaDnh.events[event].getContents();

        if (__.isArray(callbacks)) {
            __.each(callbacks, function (callback) {
                MaDnh.Helper.callFunctionDynamic(callback, data);
            });
            return true;
        }
        return false;
    };

    MaDnh.triggerEventFilter = function (event, data) {
        if (__.isUndefined(event)) {
            return null;
        }
        if (!MaDnh.eventStatus() || __.isUndefined(MaDnh.events[event])) {
            return data;
        }

        var callbacks = MaDnh.events[event].getContents();

        if (__.isArray(callbacks)) {
            __.each(callbacks, function (callback) {
                data = MaDnh.Helper.callFunctionDynamic(callback, data);
            });
        }
        return data;
    };


    /********************************************************
     *  CLASSESS
     ********************************************************/

    /*
     * MaDnh List System
     */
    MaDnh.flags = {};


    MaDnh.hasFlag = function (flag) {
        return __.has(MaDnh.flags, flag);
    };

    MaDnh.setFlag = function (flag, status) {
        if (__.isUndefined(status)) {
            status = true;
        }
        MaDnh.flags[flag] = true && status;
    };

    MaDnh.getFlag = function (flag) {
        if (MaDnh.hasFlag(flag)) {
            return true && MaDnh.flags[flag];
        }
        return false;
    };

    /*
     * End MaDnh List System
     */
    /*
     * MaDnh List System
     */


    MaDnh.list_system = {};

    MaDnh.triggerListSystemChange = function (type) {
        if (!__.isUndefined(type)) {
            MaDnh.triggerEvent('madnh_list_system_' + type + '_change');
        }
        MaDnh.triggerEvent('madnh_list_system_change');
    };

    MaDnh.createListType = function (type) {
        MaDnh.list_system[type] = {};

        MaDnh.triggerEvent('madnh_list_system_create_type', type);
        MaDnh.triggerListSystemChange();
    };
    MaDnh.hasListType = function (type) {
        return __.has(MaDnh.list_system, type);
    };
    MaDnh.removeListType = function (type) {
        if (MaDnh.hasListType(type)) {
            delete MaDnh.list_system[type];

            MaDnh.triggerEvent('madnh_list_system_remove_type', type);
            MaDnh.triggerListSystemChange();
            return true;
        }
        return false;
    };

    MaDnh.resetListType = function (type) {
        if (MaDnh.hasListType(type)) {
            MaDnh.list_system[type] = {};

            MaDnh.triggerEvent('madnh_list_system_reset_type', type);
            MaDnh.triggerListSystemChange(type);
            return true;
        }
        return false;
    };

    MaDnh.getListType = function (type) {
        if (MaDnh.hasListType(type)) {
            return MaDnh.list_system[type];
        }
        return false;
    };

    MaDnh.isEmptyListType = function (type) {
        if (!__.isUndefined(type)) {
            if (MaDnh.hasListType(type)) {
                return __.isEmpty(MaDnh.getListType(type));
            }
            return true;
        }
        return __.isEmpty(MaDnh.list_system);
    };


    MaDnh.addToListType = function (type, name, data, override) {
        if (__.isUndefined(override)) {
            override = true;
        }
        if (!__.has(MaDnh.list_system, type)) {
            MaDnh.createListType(type);
        }
        if (__.isNull(name)) {
            name = __.uniqueId('list_item_') + '_' + __.now();
        }
        if (!__.has(MaDnh.list_system[type], name) || override) {
            MaDnh.list_system[type][name] = data;

            MaDnh.triggerEvent('madnh_list_system_' + type + '_add', {
                name: name,
                data: data
            });
            MaDnh.triggerListSystemChange(type);
            return true;
        }
        return false;
    };

    MaDnh.removeFromListType = function (type, name, data) {
        if (MaDnh.hasListType(type) && !__.isUndefined(name)) {
            var result = false;

            if (!__.isNull(name)) {
                if (__.has(MaDnh.list_system[type], name)) {
                    delete MaDnh.list_system[type][name];
                    result = true;
                }
            } else {
                MaDnh.list_system[type] = __.without(MaDnh.list_system[type], data);
                result = true;
            }

            if (result) {
                MaDnh.triggerEvent('madnh_list_system_remove_item', {
                    type: type,
                    name: name,
                    data: data
                });
                MaDnh.triggerListSystemChange(type);
            }
            return true && result;
        }

        return false;
    };

    MaDnh.inListType = function (type, name, data) {
        if (MaDnh.hasListType(type) && !__.isUndefined(name)) {
            if (!__.isNull(name)) {
                return __.has(MaDnh.list_system[type], name);
            }
            return __.contains(MaDnh.list_system[type], data);
        }
        return false;
    };

    MaDnh.findInListType = function (type, callback, not_found_value) {
        if (MaDnh.hasListType(type)) {
            return __.find(MaDnh.list_system[type], callback);
        }
        return not_found_value;
    };

    MaDnh.filterInListType = function (type, callback) {
        if (MaDnh.hasListType(type)) {
            return __.filter(MaDnh.list_system[type], callback);
        }
        return [];
    };

    MaDnh.whereInListType = function (type, properties) {
        if (MaDnh.hasListType(type)) {
            return __.where(MaDnh.list_system[type], properties);
        }
        return [];
    };
    MaDnh.findWhereInListType = function (type, properties) {
        if (MaDnh.hasListType(type)) {
            return __.findWhere(MaDnh.list_system[type], properties);
        }
        return [];
    };


    /*
     * End MaDnh List System
     */


    MaDnh.Priority = function () {
        this.hightest_priority = 100;
        this.hight_priority = 250;
        this.default_priority = 500;
        this.low_priority = 750;
        this.lowest_priority = 1000;

        this.priority_level_1 = 100;
        this.priority_level_2 = 200;
        this.priority_level_3 = 300;
        this.priority_level_4 = 400;
        this.priority_level_5 = 500;
        this.priority_level_6 = 600;
        this.priority_level_7 = 700;
        this.priority_level_8 = 800;
        this.priority_level_9 = 900;
        this.priority_level_10 = 1000;
        /**
         * Value must be unique?
         *      - true  : unique on priority
         *      - false : not unique on priority
         *      - all   : unique all priority
         * @var bool
         */
        this.unique_content = false;
        /**
         * Mảng chứa bảng id các giá trị và các priority
         * @var array
         */
        this.contents = [];


        /**
         * Thêm nội dung
         * @param content Nội dung cần thêm
         * @param priority Độ ưu tiên
         */
        this.addContent = function (content, priority) {
            priority = priority || this.default_priority;
            if (!__.isArray(this.contents[priority])) {
                this.contents[priority] = [];
            }

            switch (this.unique_content) {
                case true:
                    if (!this.hasContentOnPriority(content, priority)) {
                        this.contents[priority].push(content);
                    }
                    break;

                case 'all':
                    if (false === this.hasContent(content)) {
                        this.contents[priority].push(content);
                    }
                    break;

                default:
                    this.contents[priority].push(content);
            }

        };

        /**
         * Kiểm tra tồn tại 1 action trên tất cả priority. Trả về false nếu không có, ngược lại trả về số priority của content
         * @param content
         * @returns number|bool
         */
        this.hasContent = function (content) {
            var i, j;
            for (i in this.contents) {
                for (j in this.contents[i]) {
                    if (this.contents[i][j] === content) {
                        return i;
                    }
                }
            }
            return false;
        };

        /**
         * Kiểm tra tồn tại của 1 content trên 1 priority
         * @param content
         * @param priority
         * @returns {boolean}
         */
        this.hasContentOnPriority = function (content, priority) {
            priority = priority || this.default_priority;
            if (__.isArray(this.contents[priority])) {
                for (var i in this.contents[priority]) {
                    if (content === this.contents[priority][i]) {
                        return true;
                    }
                }
                return false;
            }
            return false;
        };

        /**
         * Xóa nội dung trên toàn bộ hay 1 priority đặc biệt
         * @param content
         * @param priority
         * @returns {boolean}
         */
        this.removeContent = function (content, priority) {
            var i, j;
            if (priority) {
                if (this.contents.hasOwnProperty(priority)) {
                    for (i in this.contents[priority]) {
                        if (this.contents[priority][i] === content) {
                            delete this.contents[priority][i];
                            return true;
                        }
                    }
                }
            } else {
                var found = false;
                for (i in this.contents) {
                    for (j in this.contents[i]) {
                        if (this.contents[i][j] === content) {
                            delete this.contents[i][j];
                            found = true;
                        }
                    }
                }
                return found;
            }
            return false;
        };

        this.getContents = function () {
            var contents = [], i, j;
            var prioritys = Object.keys(this.contents);
            prioritys.sort();
            for (i in prioritys) {
                for (j in this.contents[prioritys[i]]) {
                    contents.push(this.contents[prioritys[i]][j]);
                }
            }
            return contents;
        };
    };


    MaDnh.WaiterSystem = {
        waiters: {},
        addWaiter: function (runner, once, description) {
            var key = 'waiter_' + MaDnh.Helper.randomString(20);
            this.waiters[key] = {runner: runner, once: Boolean(once), description: description};
            return key;
        },

        removeWaiter: function (waiterKey) {
            delete this.waiters[waiterKey];
        },

        hasWaiter: function (waiterKey) {
            return this.waiters.hasOwnProperty(waiterKey);
        },

        runWaiter: function (waiterKey, data) {
            if (this.hasWaiter(waiterKey)) {
                var waiter = this.waiters[waiterKey];
                MaDnh.Helper.callFunctionDynamic(waiter.runner, data);
                if (waiter.once) {
                    this.removeWaiter(waiterKey);
                }
                return true;
            }
            return false;
        }
    };

    MaDnh.FileLoader = function () {
        var fileLoaded = [];
        this.checkLoadedFile = function (file) {
            return fileLoaded.indexOf(file) != -1;
        };
        this.loadJSFile = function (file) {
            if (this.checkLoadedFile(file)) {
                return false;
            }
            var fileref = document.createElement('script');
            fileref.setAttribute("type", "text/javascript");
            fileref.setAttribute("src", file);

            if (typeof fileref != "undefined") {
                fileLoaded.push(file);
                document.getElementsByTagName("head")[0].appendChild(fileref);
            }
            return true;
        };

        this.loadCSSFile = function (file) {
            if (this.checkLoadedFile(file)) {
                return false;
            }
            var fileref = document.createElement("link");
            fileref.setAttribute("rel", "stylesheet");
            fileref.setAttribute("type", "text/css");
            fileref.setAttribute("href", file);

            if (typeof fileref != "undefined") {
                fileLoaded.push(file);
                document.getElementsByTagName("head")[0].appendChild(fileref);
            }
            return true;
        };
    };

    MaDnh.HolderSystem = function () {
        this._holders = {};
        this._class = 'place_holder';
        this._defaultHolderName = 'main_holder';
        this._defaultContentAction = 'update';

        this.fetchHolder = function () {
            var _holders = {};

            $('.' + this._class).each(function () {
                var ph = $(this);
                if (ph.data('holder_name')) {
                    _holders[ph.data('holder_name')] = ph;
                }
            });
            this._holders = _holders;
        };
        this.hasHolder = function (holderName) {
            return this._holders.hasOwnProperty(holderName);
        };
        this.removeHolder = function (holderName) {
            delete this._holders[holderName];
        };
        this.getHolder = function (holderName) {
            return this._holders[holderName] || false;
        };
        this.getHolderContent = function (holderName) {
            var h = this.getHolder(holderName);
            return h == false ? '' : h.html();

        };
        this.appendToHolder = function (content, holderName) {
            holderName = holderName || this._defaultHolderName;
            if (this.hasHolder(holderName)) {
                this._holders[holderName].append(content);
                this.fetchHolder();
            }
        };
        this.prependToHolder = function (content, holderName) {
            holderName = holderName || this._defaultHolderName;
            if (this.hasHolder(holderName)) {
                this._holders[holderName].prepend(content);
                this.fetchHolder();
            }
        };
        this.updateHolder = function (content, holderName) {
            holderName = holderName || this._defaultHolderName;
            if (this.hasHolder(holderName)) {
                this._holders[holderName].empty().append(content);
                this.fetchHolder();
            }
        };

        this.contentAction = function (content, action, holderName) {
            holderName = holderName || this._defaultHolderName;
            action = action || this._defaultContentAction;
            switch (action) {
                case 'update':
                    this.updateHolder(content, holderName);
                    break;
                case 'append':
                    this.appendToHolder(content, holderName);
                    break;
                case 'prepend':
                    this.prependToHolder(content, holderName);
                    break;
            }
        };
        this.holderLoading = function (holderName, loading) {
            if (__.isUndefined(loading)) {
                loading = true;
            }
            holderName = holderName || this._defaultHolderName;
            if (this.hasHolder(holderName) && jQuery.isLoading) {
                if (loading) {
                    console.log('loading');
                    this.getHolder(holderName).isLoading({
                        text: '',
                        tpl: '<div style="margin-top:10px; width: 100px;"><div class="ball"></div><div class="ball1"></div></div>',
                        position: "overlay"
                    });
                } else {
                    this.getHolder(holderName).isLoading('hide');
                }
            } else {
                console.log('fail loading');
            }
        };
    };

    MaDnh.AJAXWorker = function () {
        this.options = {
            requestPath: '',
            requestType: 'GET',
            dataType: '',
            requestData: [],
            requestTimeout: 10000,
            crossDomain: false,
            successFunc: function () {
            },
            errorFunc: function () {
            },
            completeFunc: function () {
            },
            beforeSend: function () {
                return true;
            }
        };
        this.option = function (option, value) {
            this.options = MaDnh.Helper.setupObject(this.options, option, value);
        };

        this.request = function (option) {
            this.option(option);
            var requestPath = this.options.requestPath;
            var requestType = this.options.requestType;
            var dataType = this.options.dataType;
            var requestData = this.options.requestData;
            var requestTimeout = this.options.requestTimeout;
            var beforeFunc = __.isFunction(this.options.beforeSend) ? this.options.beforeSend : function () {
                return true;
            };
            var successFunc = this.options.successFunc;
            var errorFunc = this.options.errorFunc;
            var completeFunc = this.options.completeFunc;

            $.ajax({
                url: requestPath,
                type: requestType,
                dataType: dataType,
                data: requestData,
                timeout: requestTimeout,
                success: function (data) {
                    console.log('send ajax success', data);
                    var result = new MaDnh.ProcessResult();
                    if (dataType == 'text' || dataType == 'html') {
                        result.addData('result', data);
                        MaDnh.Helper.callFunctionDynamic(successFunc, result);
                        return;
                    }
                    if (MaDnh.Helper.isSystemJSON(data)) {
                        result.addData('json_result_info', data.info);

                        //import data
                        __.each(data.process_data, function (value, key) {
                            result.addData(key, value);
                        });
                        //import info
                        __.each(data.process_info, function (value) {
                            result.addInfo(value.content, value.type, value.code);
                        });
                        //import action
                        __.each(data.process_action, function (value) {
                            result.addAction(value);
                        });

                        MaDnh.Helper.callFunctionDynamic(successFunc, result);
                    } else {
                        MaDnh.Helper.callFunctionDynamic(successFunc, data);
                    }


                },
                complete: function (jqxhr, textStatus) {
//                console.log('send ajax complete');
                    var data = {};
                    data.obj = jqxhr;
                    data.textStatus = textStatus;
                    MaDnh.Helper.callFunctionDynamic(completeFunc, data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    var result = new MaDnh.ProcessResult();
                    switch (jqXHR.statusText) {
                        case 'timeout':
                            result.addInfo('Server phản hồi quá lâu', result.process_error, 'timeout');
                            break;
                        case 'error':
                            switch (jqXHR.status) {
                                case 403:
                                    result.addInfo('Yêu cầu AJAX tới địa chỉ không hợp lệ', result.process_error, 403);
                                    break;
                                case 404:
                                    result.addInfo('Địa chỉ yêu cầu của AJAX không tồn tại', result.process_error, 404);
                                    break;
                                default :
                                    result.addInfo('Ajax error', result.process_error, jqXHR.status);
                            }
                            break;
                        default:
                            result.addInfo('Ajax error', result.process_error, jqXHR.status);
                    }
                    MaDnh.Helper.callFunctionDynamic(errorFunc, result);
                },
                beforeSend: function (jqXHR, settings) {
                    return MaDnh.Helper.callFunctionDynamic(beforeFunc);
                }
            });
        };
    };

    MaDnh.ProcessResult = function () {
        this.process_no_info = 'clean';
        this.process_info = 'info';
        this.process_success = 'success';
        this.process_warning = 'warning';
        this.process_error = 'error';
        this.process_danger = 'danger';

        this.status = 0;

        this._infos = [];
        this._datas = {};
        this._actions = new MaDnh.Priority();


        this.getProcessInfoValue = function (process_status) {
            switch (process_status) {
                case this.process_no_info:
                    return 0;

                case this.process_info:
                    return 1;

                case this.process_success:
                    return 2;

                case this.process_warning:
                    return 4;

                case this.process_danger:
                    return 8;

                case this.process_error:
                    return 16;
                default:
                    return false;
            }
        };

        this.addInfo = function (content, type, code) {
            var info = {
                content: content || '',
                type: type || this.process_info,
                code: code || 0
            };

            if (this.getProcessInfoValue(type) > this.status) {
                this.status = this.getProcessInfoValue(type);
            }
            this._infos.push(info);
        };

        this.getInfos = function () {
            return this._infos;
        };
        this.addData = function (dataName, dataValue) {
            this._datas[dataName] = dataValue;
        };

        this.hasData = function (dataName) {
            return this._datas.hasOwnProperty(dataName);
        };
        this.getData = function (dataName) {
            if (this.hasData(dataName)) {
                return this._datas[dataName];
            }
            return null;
        };
        this.deleteDatas = function (dataName) {
            var deletes = MaDnh.Helper.toArray(dataName), i;
            for (i in deletes) {
                delete this._datas[deletes[i]];
            }
        };

        this.getDatas = function () {
            return this._datas;
        };
        this.addAction = function (actionName, priority) {
            this._actions.addContent(actionName, priority);

        };
        /**
         * Kiểm tra tồn tại 1 action. Trả về false nếu không có, ngược lại trả về số priority của action
         * @param actionName
         * @returns number|bool
         */
        this.hasAction = function (actionName) {
            return this._actions.hasAction(actionName);
        };
        this.removeAction = function (actionName) {
            return this._actions.removeContent(actionName, null);
        };

        this.getActions = function () {
            return this._actions.getContents();
        };


        this.importResult = function (progress_result_obj) {
            var data = progress_result_obj._datas;
            var info = progress_result_obj._infos;
            var action = progress_result_obj._actions;
            var i, j, priority;

            for (i in info) {
                this.addInfo(info[i].message, info[i].type, info[i].code);
            }
            for (j in data) {
                this.addData(j, data[j]);
            }

            for (priority in action) {
                for (j in action[priority]) {
                    this.addAction(action[priority][j], priority);
                }
            }
        };

        this.isError = function () {
            return this.status == this.getProcessInfoValue(this.process_error);
        };
        this.hasWarning = function () {
            return this.status >= this.getProcessInfoValue(this.process_warning);
        };

        this.hasDanger = function () {
            return this.status >= this.getProcessInfoValue(this.process_danger);
        };
        this.isSuccess = function () {
            return this.status <= this.getProcessInfoValue(this.process_success);
        };

        this.setStatus = function (process_type) {
            this.status = Number(this.getProcessInfoValue(process_type));
        };

        this.getStatus = function () {
            return this.status;
        };
    };

    /**
     * Tạo Bootstrap Modal.
     * ** Các tùy chọn:
     *  - close_by_button: Chỉ đóng modal khi bấm vào các button. Nếu False (mặc định) sẽ có thể đóng modal khi nhấn vào
     *                      backdrop, nhấn phím Esc hay biểu tượng close ở header
     *  - has_header    : Modal có header hay không
     *  - size          : Kích thước modal, bao gồm lg (lớn), sm (nhỏ). Mặc định là rỗng - kích thước trung bình
     *
     * ** Các sự kiện liên quan tới modal:
     * - show       : Khi modal bắt đầu hiển thị
     * - shown      : Khi modal đã được hiển thị đầy đủ (sẽ chờ cho các CSS transition hoàn kết thúc)
     * - hide      : Khi modal bắt đầu đóng
     * - shown      : Khi modal đã được đóng hoàn tất (sẽ chờ cho các CSS transition hoàn kết thúc)
     *
     * ** Các
     * @constructor
     */
    MaDnh.BootstrapDialog = function () {

        this.options = {
            close_by_button: false,
            has_header: true,
            size: '',
            padding: true,
            overflow: 'hidden',
            dynamic_content: false,
            request_options: {}
        };
        this.title = 'Thông báo';
        this.content = '';


        this.events = {
            show: new MaDnh.Priority(),
            shown: new MaDnh.Priority(),
            hide: new MaDnh.Priority(),
            hidden: new MaDnh.Priority()
        };
        this.buttons = {};
        this.type = 'info';

        this.id = undefined;
        this.button_click_waiter = undefined;
        this.clicked = false;
        this.status = 'hidden';
        this.aw = new MaDnh.AJAXWorker();
        this.request_inited = false;


        /**
         * Cài đặt các tùy chọn
         * @param {{}|string} option Chuỗi tên tùy chọn hoặc object chứa các tùy chọn và các giá trị
         * @param {*} value Giá trị cho tùy chọn
         */
        this.option = function (option, value) {
            this.options = MaDnh.Helper.setupObject(this.options, option, value);
        };

        /**
         * Cài đặt các event
         * @param {{}|string} event Chuỗi tên event hoặc object chứa tên các event và các handler
         * @param {*} handler Handler cho event
         * @param {number} priority Priority của event
         */
        this.setModalEvent = function (event, handler, priority) {
            if (!__.isUndefined(handler)) {
                if (!__.has(this.events, event)) {
                    this.events[event] = new MaDnh.Priority();
                }
                priority = priority || this.events[event].default_priority;
                this.events[event].addContent(handler, priority);
            } else if (__.isObject(event)) {
                __.each(event, function (tmpHandler, tmpEvent) {
                    arguments.callee(tmpEvent, tmpHandler);
                });
            }
        };

        /**
         * Thêm 1 button cho modal
         * @param name Tên button
         * @param {{}} info Các thông tin về button. Bao gồm:
         *                  - label  : Chuỗi tiêu đề button
         *                  - icon   : Icon, dùng Fontawesome
         *                  - type   : Loại button
         *                  - handler : Handler khi button được nhấn
         *                  - is_default : Có phải là button mặc định. Handler của button mặc định sẽ được dùng
         *                  nếu modal không có có handler cho event hidden
         *                  - hide_modal    : Ẩn modal trước khi call handler của button. Mặc định là true.
         *                  Tác vụ thực thi bởi click button handler sẽ chạy sau hidden event của modal
         *                  - on_hide   : Thêm sự kiện click button ở event hide modal (trước khi xóa dialog) khi thuộc
         *                  tính hide_modal là TRUE.
         */
        this.addButton = function (name, info) {
            info = __.extend({}, {
                label: name,
                icon: '',
                type: 'default',
                handler: undefined,
                is_default: false,
                hide_modal: true,
                on_hide: false
            }, info);
            this.buttons[name] = info;
        };

        /**
         * Xử lý tác vụ của 1 button
         * @param name
         */
        this.clickButton = function (name) {
            if (__.has(this.buttons, name)) {
                var button = this.buttons[name];
                var info = {
                    modal_id: this.id,
                    button_name: name
                };
                this.clicked = true;
                if (this.isShown()) {
                    if (button['hide_modal']) {
                        $('#' + this.id).on((button['on_hide'] ? 'hide' : 'hidden') + '.bs.modal', function () {
                            MaDnh.Helper.callFunctionDynamic(button['handler'], info);
                        });
                        this.hide();
                    } else {
                        MaDnh.Helper.callFunctionDynamic(button['handler'], info);
                    }
                } else {
                    MaDnh.Helper.callFunctionDynamic(button['handler'], info);
                }
            }
        };

        this.isShowing = function () {
            return this.status == 'show';
        };
        this.isShown = function () {
            return this.status == 'shown';
        };
        this.isHiding = function () {
            return this.status == 'hide';
        };
        this.isHidden = function () {
            return this.status == 'hidden';
        };


        this.getInstance = function () {
            return this;
        };

        this.getDialog = function () {
            if (this.isShown()) {
                return $('#' + this.id);
            }
            return false;
        };

        this.initRequest = function () {
            if (this.request_inited || !this.options.dynamic_content) {
                return;
            }


            var instance = this.getInstance();
            var progress_bar = '';
            progress_bar += '<div class="progress no-rounded progress-striped active">';
            progress_bar += '  <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">';
            progress_bar += '	<span class="sr-only">Đang tải...</span>';
            progress_bar += '  </div>';
            progress_bar += '</div>';


            if (__.isUndefined(this.options.request_options['successFunc'])) {
                this.options.request_options['successFunc'] = function (data) {
                    var content = 'Nội dung không phù hợp';
                    var dialog = instance.getDialog();
                    if (dialog !== false) {
                        if (__.isString(data)) {
                            content = data;
                        } else if (MaDnh.Helper.isProcessResult(data) && data.hasData('result')) {
                            content = data.getData('result');
                        }
                        dialog.find('.modal-body').html(content);
                    }
                }
            }

            if (__.isUndefined(this.options.request_options['errorFunc'])) {
                this.options.request_options['errorFunc'] = function (data) {
                    var content = 'Nội dung không phù hợp';
                    var dialog = instance.getDialog();
                    console.log('YAHOOO error', data, dialog);
                    if (dialog !== false) {
                        if (MaDnh.Helper.isProcessResult(data)) {
                            content = '';
                            __.each(data.getInfos(), function (info) {
                                content += MaDnh.Template.bootstrapAlert(info.content, info.type);
                            })
                        }
                        dialog.find('.modal-body').html(content);
                    }
                }
            }


            this.aw.option(this.options.request_options);
            if (__.isEmpty(this.aw.options.requestPath) && !__.isEmpty(this.content)) {
                this.aw.options.requestPath = this.content;
            }
            if (__.isEmpty(this.content)) {
                this.content = progress_bar;
            }

            instance.setModalEvent('shown', function (info) {
                instance.aw.request();
            }, MaDnh.Priority.hightest_priority);

            this.request_inited = true;
        };

        /**
         * Hiển thị dialog
         * @returns {string}
         */
        this.show = function () {
            if (this.isShowing() || this.isShown()) {
                return this.id;
            }

            var instance = this.getInstance();
            var dialogs = $('body').data('dialogs') || 0;


            this.id = 'dialog_' + MaDnh.Helper.randomString(15) + __.uniqueId();

            this.button_click_waiter = MaDnh.WaiterSystem.addWaiter(function (name) {
                instance.clickButton(name);
            }, false, 'Modal: ' + this.id + ' >>> Button click waiter');

            var dialog_id = this.id;
            var template = '';
            var default_button_name = undefined;
            var options = {
                backdrop: !Boolean(this.options.close_by_button) || 'static',
                keyboard: !Boolean(this.options.close_by_button)
            };
            var waiter_keys = [];
            var body_style = [];
            var size = this.options.size;


            this.initRequest();


            if (!__.isEmpty(size) && (-1 !== ['lg', 'sm'].indexOf(size))) {
                size = 'modal-' + size;
            }

            template += '<div class="modal fade" id="' + this.id + '" tabindex="-1" role="dialog" aria-hidden="true">'
            template += '  <div class="modal-dialog ' + size + '">'
            template += '	<div class="modal-content modal-no-shadow modal-no-border">'
            if (this.options.has_header) {
                template += '	  <div class="modal-header bg-' + MaDnh.Template.bootstrapColorType(this.type) + ' no-border">'

                if (!this.options.close_by_button) {
                    template += '		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>'
                }

                template += '		<h4 class="modal-title">' + __.escape(this.title) + '</h4>'
                template += '	  </div>'
            }
            if (this.options.padding == false) {
                body_style.push('padding: 0px;');
            }
            body_style.push('overflow: ' + this.options.overflow + ';');


            template += '	  <div class="modal-body" style="' + body_style.join('') + '">'
            template += this.content;
            template += '	  </div>'
            if (!__.isEmpty(this.buttons)) {
                template += '	  <div class="modal-footer">'
                __.each(this.buttons, function (button, name) {
                    var icon = '';

                    if (!__.isEmpty(button.icon)) {
                        icon = '<i class="fa fa-' + button.icon + '"></i>';
                    }
                    if (button.is_default) {
                        default_button_name = name;
                    }

                    template += '<button type="button" class="btn btn-' + button.type + '"';
                    template += ' onclick="MaDnh.WaiterSystem.runWaiter(\'' + instance.button_click_waiter + '\', \'' + name + '\')" >' + icon + button.label + '</button>'
                });

                template += '	  </div>'
            }

            template += '	</div>'
            template += '  </div>'
            template += '</div>'

            $('body').append(template);
            $('body').data('dialogs', dialogs + 1);

            __.each(['show', 'shown', 'hide', 'hidden'], function (status) {
                instance.setModalEvent(status, function () {
                    instance.status = status;
                }, MaDnh.Priority.lowest_priority);
            });
            __.each(this.events, function (priority, event) {
                var handlers = priority.getContents();

                if (__.isArray(handlers) && !__.isEmpty(handlers)) {
                    __.each(handlers, function (handler) {
                        var waiter_key = MaDnh.WaiterSystem.addWaiter(handler, true, 'Modal: ' + dialog_id + ' > Event: ' + event);
                        waiter_keys.push(waiter_key);
                        $('#' + dialog_id).on(event + '.bs.modal', function (e) {
                            MaDnh.WaiterSystem.runWaiter(waiter_key, {modal_id: dialog_id, event: e});
                        });
                    });
                }
            });


            $('#' + dialog_id).on('hidden.bs.modal', function () {
                var dialogs = $('body').data('dialogs') || 1; //Số dialog hiện đang mở

                //Ánh xạ button mặc định khi thoát mà không click vào button
                if (!__.isEmpty(instance.buttons) && !instance.clicked && !__.isUndefined(default_button_name)) {
                    MaDnh.WaiterSystem.runWaiter(instance.button_click_waiter, default_button_name);
                }

                //Gỡ các waiter key
                __.each(waiter_keys, function (waiter) {
                    MaDnh.WaiterSystem.removeWaiter(waiter);
                });
                MaDnh.WaiterSystem.removeWaiter(instance.button_click_waiter);

                //Xóa DOM của dialog
                $('#' + dialog_id).remove();

                //Đặt lại class modal-open nếu vẫn còn dialog đang mở
                $('body').data('dialogs', dialogs - 1);
                if ($('body').data('dialogs') > 0) {
                    $('body').addClass('modal-open');
                }
            });

            $('#' + dialog_id).modal(options);
            return dialog_id;
        };

        /**
         * Ẩn dialog
         */
        this.hide = function () {
            if (this.isShown()) {
                $('#' + this.id).modal('hide');
            }
        };


    };


    /********************************************************
     *  INIT
     *
     ********************************************************/
    var init_contents = new MaDnh.Priority();

    MaDnh.addInitCommand = function (command, priority) {
        init_contents.addContent(command, priority);
    };
    MaDnh.init = function () {
        var commands = init_contents.getContents();
        for (var i in commands) {
            MaDnh.Helper.callFunctionDynamic(commands[i]);
        }
    };


    /********************************************************
     *  MaDnh jQuery plugin
     ********************************************************/


    /**
     * MaDnh Ajax Form jQuery plugin
     */
    MaDnh.addInitCommand(function () {
        (function ($) {
            $.fn.sMAjaxForm = function (options) {
                var settings = {
                    disable_on_send: true,
                    status_selector: 'input[type="submit"], button[type="submit"]',
                    sending_content: 'Đang gửi'
                };
                if (typeof options == 'object') {
                    settings = $.extend(settings, options);
                }
                var form = $(this);
                var target_button = form.find(settings.status_selector);
                var aw = new MaDnh.AJAXWorker();
                if (form.find('div.process_info').length == 0) {
                    form.prepend($('<div class="process_info"></div>'));
                }
                var info_element = form.find('div.process_info');
                var old_label = target_button.html();

                form.submit(function (event) {
                    aw.option({
                        requestPath: form.prop('action') || window.location.href,
                        requestData: MaDnh.DOM.getFormInputValue(form),
                        requestType: form.prop('method') || 'POST',
                        beforeSend: function () {
                            info_element.html('');
                            setFormStatus(true);
                            return true;
                        },
                        completeFunc: function () {
                            setFormStatus(false);

                        },
                        successFunc: function (data) {
                            if (data instanceof MaDnh.ProcessResult) {
                                info_element.html('');
                                __.each(data.getInfos(), function (info) {
                                    info_element.append(MaDnh.Template.bootstrapAlert(info.content, info.type));
                                });
                                if (data.hasData('new_form_data')) {
                                    console.log('Assign new data', data.getData('new_form_data'));
                                    console.log('RESULT', MaDnh.DOM.assignFormData(form, data.getData('new_form_data'), null));
                                } else {
                                    console.log('Ko co data moi');
                                }
                                MaDnh.Helper.progressAjaxAction(data.getActions());
                            }
                        },
                        errorFunc: function (data) {
                            console.log('Error', data);
                            if (data instanceof MaDnh.ProcessResult) {
                                info_element.html('');
                                __.each(data.getInfos(), function (info) {
                                    info_element.append(MaDnh.Template.bootstrapAlert(info.content, info.type));
                                });
                            }
                        }
                    });


                    aw.request();


                    event.preventDefault();
                });

                var setFormStatus = function (sending) {

                    if (sending) {
                        settings.disable_on_send && form.find(':input, textarea, select').prop("disabled", true);
                        form.data('ajax_form_status', 'sending');
                        target_button.html(settings.sending_content);
                    } else {
                        settings.disable_on_send && form.find(':input, textarea, select').prop("disabled", false);
                        form.data('ajax_form_status', 'complete');
                        target_button.html(old_label);
                    }

                };

            };
        })(jQuery);

    });


}).call(this);