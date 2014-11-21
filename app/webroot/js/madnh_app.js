(function () {

    var root = this;
    var previousApp = root.App;
    var underScore = _.noConflict();

    var App = function (obj) {
        if (obj instanceof App) {
            return obj;
        }
        if (!(this instanceof App)) {
            return new App(obj);
        }
    };
    root.App = App;
    App.noConflict = function () {
        root.App = previousApp;
        return this;
    };

    App.config = {
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
    App.Helper = {};

    App.Helper.toArray = function (value) {
        if (underScore.isArray(value)) {
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
    App.Helper.serialize = function (mixed_value) {
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


    App.Helper.randomItem = function (items) {
        return items[Math.floor(Math.random() * items.length)];
    };

    App.Helper.randomString = function (length, chars) {
        var result = '';
        if (!chars) {
            chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }
        for (var i = length; i > 0; --i) {
            result += chars[Math.round(Math.random() * (chars.length - 1))];
        }
        return result;
    };

    App.Helper.callFunctionDynamic = function (func, data) {
        if (!underScore.isUndefined(func)) {
            if (typeof func == 'string') {
                try {
                    window[func](data);
                    return true;
                } catch (e) {
                    try {
                        eval(func);
                    } catch (e) {
                        return false;
                    }
                }
            } else if (underScore.isFunction(func)) {
                try {
                    func(data);
                    return true;
                } catch (e) {
                    return false;
                }
            } else if (underScore.isArray(func)) {
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
    App.Helper.isSystemJSON = function (data) {
        if (data.hasOwnProperty('info')
            && data.hasOwnProperty('process_info')
            && data.hasOwnProperty('process_data')
            && data.hasOwnProperty('process_action')) {
            return data.info.json_provider == 'json_output' && data.info.system == 'sModular'
        }
        return false;
    };

    App.Helper.isProcessResult = function (object) {
        return object instanceof App.ProcessResult;
    };


    App.Helper.clearInRange = function (variable, min, max) {
        return Math.max(min, Math.min(variable, max));
    };
    App.Helper.progressAjaxAction = function (data) {
        if (App.Helper.isSystemJSON(data)) {
            var actions = data.getActions();
            var i;
            console.log(actions);
            for (i in actions) {
                console.log(actions[i]);
                App.Helper.callFunctionDynamic(actions[i], data);
            }
        }
    };

    App.Helper.setupObject = function (object, option, value) {
        if (!underScore.isObject(object)) {
            object = {};
        }
        if (!underScore.isUndefined(value)) {
            object[option] = value;
        } else if (underScore.isObject(option)) {
            object = underScore.extend({}, object, option);
        }
        return object;
    };


    App.Helper.alert = function (content, callback, option) {
        var default_option = {
            type: 'info'
        };
        option = underScore.extend({}, default_option, option);

        var func = function (info) {
            App.Helper.callFunctionDynamic(callback, info)
        };

        var dialog = new App.BootstrapDialog();
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
        underScore.each(buttons, function (btn_info, btn_name) {
            dialog.addButton(btn_name, btn_info);
        });
        dialog.show();
    };


    App.Helper.confirm = function (content, callback, option) {
        var default_option = {
            type: 'info',
            yes_label: 'Đồng ý',
            no_label: 'Không',

            default_button: 'no'
        };
        option = underScore.extend({}, default_option, option);

        var func = function (info) {
            var result = false;
            if (underScore.has(info, 'button_name')) {
                result = info['button_name'] == 'yes';
            }
            App.Helper.callFunctionDynamic(callback, result)
        };

        var dialog = new App.BootstrapDialog();
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

        if (underScore.has(buttons, option.default_button)) {
            buttons[option.default_button].is_default = true;
        }

        dialog.content = content;
        dialog.type = option.type;
        underScore.each(buttons, function (btn_info, btn_name) {
            dialog.addButton(btn_name, btn_info);
        });
        dialog.show();
    };

    App.Helper.iframeDialog = function (url, option) {
        var default_option = {
            type: 'info',
            height: '300',
            title: 'Thông báo',
            size: 'lg',
            close_by_button: false
        };
        option = underScore.extend({}, default_option, option);
        var dialog = new App.BootstrapDialog();
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
            underScore.each(buttons, function (btn_info, btn_name) {
                dialog.addButton(btn_name, btn_info);
            });
        }


        dialog.show();
    };

    App.Helper.formDialog = function (form_content, callback, option) {
        var default_option = {
            type: 'info',
            title: 'Nhập liệu',
            submit_label: 'Ok',
            close_label: 'Cancel'
        };
        option = underScore.extend({}, default_option, option);

        var func = function (info) {
            var result = false;
            if (underScore.has(info, 'button_name') && info['button_name'] == 'submit') {
                result = App.DOM.getFormInputValue('#' + info['modal_id'] + ' .modal-body');
            }
            App.Helper.callFunctionDynamic(callback, result)
        };

        var dialog = new App.BootstrapDialog();


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

        underScore.each(default_option, function (value, key) {
            delete option[key];
        });
        dialog.option(option);

        underScore.each(buttons, function (btn_info, btn_name) {
            dialog.addButton(btn_name, btn_info);
        });


        dialog.show();
    };


    /**
     * Prompt với 1 giá trị chuỗi
     * @param title
     * @param callback
     */
    App.Helper.prompt = function (title, callback) {
        var form = '<p>' + title + '</p>' + '<input class="form-control" name="prompt_data" type="text">';
        App.Helper.formDialog(form, function (result) {
            if (underScore.has(result, 'prompt_data')) {
                App.Helper.callFunctionDynamic(callback, result['prompt_data']);
            } else {
                App.Helper.callFunctionDynamic(callback, false);
            }
        });

    };

    /**
     * Prompt với nhiều phần tử
     * @param contents
     * @param callback
     */
    App.Helper.prompts = function (contents, callback) {
        if (underScore.isUndefined(contents)) {
            contents = App.Helper.promptTextElement('prompt_data', '');
        }

        if (underScore.isArray(contents)) {
            contents = contents.join();
        }

        App.Helper.formDialog(contents, function (result) {
            App.Helper.callFunctionDynamic(callback, result);
        });

    };

    /**
     * Tạo phần tử text element cho prompt
     * @param name Tên giá trị
     * @param title Tiêu đề
     * @param default_value Giá tị mặc định
     * @returns {string}
     */
    App.Helper.promptTextElement = function (name, title, default_value) {
        default_value = default_value || '';
        title = title || name;

        return '<p>' + title + '<br /><input type="text" name="' + name + '" value="' + default_value + '" /></p>';
    };

    /**
     * Tạo element cho prompt. Vd: App.Helper.promptCheckboxElement('checkbox_name', 'Tieu de', {a:'A', b:'B'})
     *
     * @param name
     * @param title
     * @param values
     * @returns {string}
     */
    App.Helper.promptCheckboxElement = function (name, title, values) {
        title = title || name;
        var checkbox_values = {};
        var content = '<p>' + title + '<br />';
        checkbox_values = underScore.extend({}, checkbox_values, values);

        underScore.each(checkbox_values, function (value, key) {
            content += '<label><input type="checkbox" name="' + name + '" value="' + key + '" /> ' + value + '</label><br />';
        });
        return content + '</p>';
    };


    /********************************************************
     *  DOM
     ********************************************************/
    App.DOM = {};

    App.DOM.disableElement = function (selector) {
        $(selector).attr('disabled', 'disabled');
    };
    App.DOM.enableElement = function (selector) {
        $(selector).removeAttr('disabled');
    };

    App.DOM.getSelectOptions = function (selector, values) {
        var select = $(selector);

        if (underScore.isArray(values)) {
            values = underScore.map(values, function (value) {
                return 'option[value="' + value + '"]';
            });
            return select.find(values.join(', '));
        }
        return select.find('option[value="' + values + '"]');
    };
    App.DOM.selectValue = function (selector, values) {
        var options = this.getSelectOptions(selector, values);
        underScore.each(options, function (e) {
            e.prop('selected', true);
        });
    };

    App.DOM.selectUnselectValue = function (selector, values) {
        var options = this.getSelectOptions(selector, values);
        underScore.each(options, function (e) {
            e.prop('selected', false);
        });
    };

    App.DOM.selectRemoveOption = function (selector, values) {
        var options = this.getSelectOptions(selector, values);
        options.remove();
    };

    App.DOM.selectDesableOption = function (selector, values) {
        var options = this.getSelectOptions(selector, values);
        underScore.each(options, function (e) {
            e.attr('disabled', 'disabled');
        });
    };
    App.DOM.selectEnableOption = function (selector, values) {
        var options = this.getSelectOptions(selector, values);
        underScore.each(options, function (e) {
            e.removeAttr('disabled');
        });
    };
    App.DOM.checkRadio = function (radio_name, value) {
        $("input:radio[name='" + radio_name + "']:checked").prop('checked', false);
        $("input:radio[name='" + radio_name + "'][value=" + value + "]").prop('checked', true);
    };
    App.DOM.getRadioValue = function (radio_name) {
        return $("input:radio[name ='" + radio_name + "']:checked").val();
    };


    App.DOM.setCheckBoxStatus = function (selector, status) {
        $(selector).prop('checked', status);
    };

    App.DOM.setTableCheckboxsStatus = function toggleCheckboxs(table_selector, status) {
        var check_status = status ? ':not(:checked)' : ':checked';
        var checkboxs = $(table_selector + ' tr td input:checkbox' + check_status);
        console.log('Check status', check_status);
        checkboxs.each(function (index, el) {
            $(el).prop('checked', status);
        });
    };


    /**
     * Lấy dữ liệu các input trong form và trả về dạng <<ten input>> => <<gia tri>>
     * @param {string} form_selector
     * @returns {{}}
     */
    App.DOM.getFormInputValue = function (form_selector) {
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
                        if (underScore.isUndefined(result[checkboxName])) {
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
    App.DOM.assignFormData = function (form, data, prefix) {

        if (!underScore.isString(prefix) || underScore.isEmpty(prefix)) {
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
                    if (underScore.isArray(data[prop])) {
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
    App.Template = {
        compiled: {},
        templated: {}
    };


    /**
     * Compile 1 handlebars templates
     * @param {type} templateName   Tên của templates
     * @param {type} content    Nội dung của templates, dùng jquery để lấy nội dung
     * @returns {undefined}
     */
    App.Template.addCompiledTemplate = function (templateName, content) {
        if (window.Handlebars && underScore.isUndefined(this.compiled[templateName])) {
            this.compiled[templateName] = Handlebars.compile(content);
        }
    };


    /**
     * Compiled tất cả các templates handlebars trong page <br />
     * Các handlebars templates phải có ID bắt đầu bằng 'template_' và thuộc tính TYPE là 'text/x-handlebars-templates'
     * @returns {undefined}
     */
    App.Template.compileAllHandlebarsTemplate = function ($source) {
        if (underScore.isUndefined($source)) {
            $source = $('html');
        }
        var tmp = $source.find('script[id^=template_]');
        var tmpElement = '';

        tmp.each(function (i, el) {
            tmpElement = $(el);
            this.addCompiledTemplate(tmpElement.attr('id').replace('template_', ''), tmpElement.html());
        });
        return tmp.length;
    };


    /**
     * Kiểm tra có 1 handlebars templates đã compile không
     * @param templateName Tên templates
     * @returns {boolean}
     */
    App.Template.isCompiledTemplate = function (templateName) {
        return underScore.isUndefined(this.compiled[templateName]);
    };

    /**
     * Tạo ra templates từ 1 Handlebars templates compiled
     * @param {String} templateName   Tên của handlebars templates compiled
     * @param {Object} data   Các giá trị cần ánh xạ vào templates, là dạng đối tượng, vd: {a:'A', b:'B'}
     * @returns {String}    Template đã được ánh xạ giá trị
     */
    App.Template.createTemplate = function (templateName, data) {
        var _data = data || {};
        if (this.isCompiledTemplate(templateName)) {
            return this.compiled[templateName](_data);
        }
        return '';
    };

    /**
     * Thêm 1 templates đã ánh xạ vào biến lưu trữ để có thể dùng lại nhiều lần
     * @param {type} templateName   Tên templates
     * @param {type} templateContent    Nội dung templates đã được ánh xạ
     * @returns {undefined}
     */
    App.Template.addTemplated = function (templateName, templateContent) {
        this.templated[templateName] = templateContent;
    };

    /**
     * Kiểm tra trong biến lưu trữ chung có 1 templates nào chưa
     * @param {String} templateName
     * @returns {Boolean}
     */
    App.Template.isTemplated = function (templateName) {
        return !underScore.isUndefined(this.templated[templateName]);
    };

    /**
     * Lấy ra 1 templates đã thêm vào biến lưu trữ chung
     * @param {String} templateName   Tên templates đã thêm
     * @returns {*} Trả về nội dung của templates cần lấy, <b>FALSE</b> nếu templates cần lấy chưa được thêm vào biến lưu trữ chung
     */
    App.Template.getTemplated = function (templateName) {
        if (this.isTemplated(templateName)) {
            return false;
        }
        return this.templated[templateName];
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
    App.Template.createElement = function (data) {
        if (underScore.isUndefined(data._name)) {
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


        if ((data._name == 'select' || data._name == 'optgroup') && !underScore.isUndefined(data.value) && underScore.isArray(data.value)) {

            for (var i = 0, l = data.value.length; i < l, underScore.isObject(data.value[i]); i++) {
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

    App.Template.bootstrapColorType = function (type) {
        var types = {
            info: 'info',
            clean: 'info',
            primary: 'primary',
            success: 'success',
            warning: 'warning',
            danger: 'danger',
            error: 'danger'
        };
        if (!underScore.has(types, type)) {
            type = 'info';
        }
        return underScore.property(type)(types);
    };

    App.Template.bootstrapAlert = function (content, type) {
        return '<div class="alert alert-' + App.Template.bootstrapColorType(type) + ' square fade in">' + content + '</div>'
    };
    App.Template.getAjaxAlertContent = function (result) {
        var contents = '';
        if (App.Helper.isProcessResult(result)) {
            underScore.each(result.getInfos(), function (info_obj) {
                contents += App.Template.bootstrapAlert(info_obj.content, info_obj.type);
            });
        }
        return contents;
    };

    App.Template.alertAjaxResult = function (result, callback) {
        var content = this.getAjaxAlertContent(result);
        if (content) {
            App.Helper.alert(content, callback);
        } else {
            App.Helper.callFunctionDynamic(callback);
        }
    };

    /********************************************************
     *  CLASSESS
     ********************************************************/


    App.Priority = function () {
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
            if (!underScore.isArray(this.contents[priority])) {
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
            if (underScore.isArray(this.contents[priority])) {
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
    App.WaiterSystem = {
        waiters: {},
        addWaiter: function (runner, once, description) {
            var key = 'waiter_' + App.Helper.randomString(20);
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
                App.Helper.callFunctionDynamic(waiter.runner, data);
                if (waiter.once) {
                    this.removeWaiter(waiterKey);
                }
                return true;
            }
            return false;
        }
    };

    App.FileLoader = function () {
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

    App.HolderSystem = function () {
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
            if (underScore.isUndefined(loading)) {
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

    App.AJAXWorker = function () {
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
            this.options = App.Helper.setupObject(this.options, option, value);
        };

        this.request = function (option) {
            this.option(option);
            var requestPath = this.options.requestPath;
            var requestType = this.options.requestType;
            var dataType = this.options.dataType;
            var requestData = this.options.requestData;
            var requestTimeout = this.options.requestTimeout;
            var beforeFunc = underScore.isFunction(this.options.beforeSend) ? this.options.beforeSend : function () {
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
                    var result = new App.ProcessResult();
                    if (dataType == 'text' || dataType == 'html') {
                        result.addData('result', data);
                        App.Helper.callFunctionDynamic(successFunc, result);
                        return;
                    }
                    if (App.Helper.isSystemJSON(data)) {
                        result.addData('json_result_info', data.info);

                        //import data
                        underScore.each(data.process_data, function (value, key) {
                            result.addData(key, value);
                        });
                        //import info
                        underScore.each(data.process_info, function (value) {
                            result.addInfo(value.content, value.type, value.code);
                        });
                        //import action
                        underScore.each(data.process_action, function (value) {
                            result.addAction(value);
                        });

                        App.Helper.callFunctionDynamic(successFunc, result);
                    } else {
                        App.Helper.callFunctionDynamic(successFunc, data);
                    }


                },
                complete: function (jqxhr, textStatus) {
//                console.log('send ajax complete');
                    var data = {};
                    data.obj = jqxhr;
                    data.textStatus = textStatus;
                    App.Helper.callFunctionDynamic(completeFunc, data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    var result = new App.ProcessResult();
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
                    App.Helper.callFunctionDynamic(errorFunc, result);
                },
                beforeSend: function (jqXHR, settings) {
                    return App.Helper.callFunctionDynamic(beforeFunc);
                }
            });
        };
    };

    App.ProcessResult = function () {
        this.process_no_info = 'clean';
        this.process_info = 'info';
        this.process_success = 'success';
        this.process_warning = 'warning';
        this.process_error = 'error';
        this.process_danger = 'danger';

        this.status = 0;

        this._infos = [];
        this._datas = {};
        this._actions = new App.Priority();


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
            var deletes = App.Helper.toArray(dataName), i;
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
    App.BootstrapDialog = function () {

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
            show: new App.Priority(),
            shown: new App.Priority(),
            hide: new App.Priority(),
            hidden: new App.Priority()
        };
        this.buttons = {};
        this.type = 'info';

        this.id = undefined;
        this.button_click_waiter = undefined;
        this.clicked = false;
        this.status = 'hidden';
        this.aw = new App.AJAXWorker();
        this.request_inited = false;


        /**
         * Cài đặt các tùy chọn
         * @param {{}|string} option Chuỗi tên tùy chọn hoặc object chứa các tùy chọn và các giá trị
         * @param {*} value Giá trị cho tùy chọn
         */
        this.option = function (option, value) {
            this.options = App.Helper.setupObject(this.options, option, value);
        };

        /**
         * Cài đặt các event
         * @param {{}|string} event Chuỗi tên event hoặc object chứa tên các event và các handler
         * @param {*} handler Handler cho event
         * @param {number} priority Priority của event
         */
        this.setModalEvent = function (event, handler, priority) {
            if (!underScore.isUndefined(handler)) {
                if (!underScore.has(this.events, event)) {
                    this.events[event] = new App.Priority();
                }
                priority = priority || this.events[event].default_priority;
                this.events[event].addContent(handler, priority);
            } else if (underScore.isObject(event)) {
                underScore.each(event, function (tmpHandler, tmpEvent) {
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
            info = underScore.extend({}, {
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
            if (underScore.has(this.buttons, name)) {
                var button = this.buttons[name];
                var info = {
                    modal_id: this.id,
                    button_name: name
                };
                this.clicked = true;
                if (this.isShown()) {
                    if (button['hide_modal']) {
                        $('#' + this.id).on((button['on_hide'] ? 'hide' : 'hidden') + '.bs.modal', function () {
                            App.Helper.callFunctionDynamic(button['handler'], info);
                        });
                        this.hide();
                    } else {
                        App.Helper.callFunctionDynamic(button['handler'], info);
                    }
                } else {
                    App.Helper.callFunctionDynamic(button['handler'], info);
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


            if (underScore.isUndefined(this.options.request_options['successFunc'])) {
                this.options.request_options['successFunc'] = function (data) {
                    var content = 'Nội dung không phù hợp';
                    var dialog = instance.getDialog();
                    if (dialog !== false) {
                        if (underScore.isString(data)) {
                            content = data;
                        } else if (App.Helper.isProcessResult(data) && data.hasData('result')) {
                            content = data.getData('result');
                        }
                        dialog.find('.modal-body').html(content);
                    }
                }
            }

            if (underScore.isUndefined(this.options.request_options['errorFunc'])) {
                this.options.request_options['errorFunc'] = function (data) {
                    var content = 'Nội dung không phù hợp';
                    var dialog = instance.getDialog();
                    console.log('YAHOOO error', data, dialog);
                    if (dialog !== false) {
                        if (App.Helper.isProcessResult(data)) {
                            content = '';
                            underScore.each(data.getInfos(), function (info) {
                                content += App.Template.bootstrapAlert(info.content, info.type);
                            })
                        }
                        dialog.find('.modal-body').html(content);
                    }
                }
            }


            this.aw.option(this.options.request_options);
            if (underScore.isEmpty(this.aw.options.requestPath) && !underScore.isEmpty(this.content)) {
                this.aw.options.requestPath = this.content;
            }
            if (underScore.isEmpty(this.content)) {
                this.content = progress_bar;
            }

            instance.setModalEvent('shown', function (info) {
                instance.aw.request();
            }, App.Priority.hightest_priority);

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


            this.id = 'dialog_' + App.Helper.randomString(15) + underScore.uniqueId();

            this.button_click_waiter = App.WaiterSystem.addWaiter(function (name) {
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


            if (!underScore.isEmpty(size) && (-1 !== ['lg', 'sm'].indexOf(size))) {
                size = 'modal-' + size;
            }

            template += '<div class="modal fade" id="' + this.id + '" tabindex="-1" role="dialog" aria-hidden="true">'
            template += '  <div class="modal-dialog ' + size + '">'
            template += '	<div class="modal-content modal-no-shadow modal-no-border">'
            if (this.options.has_header) {
                template += '	  <div class="modal-header bg-' + App.Template.bootstrapColorType(this.type) + ' no-border">'

                if (!this.options.close_by_button) {
                    template += '		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>'
                }

                template += '		<h4 class="modal-title">' + underScore.escape(this.title) + '</h4>'
                template += '	  </div>'
            }
            if (this.options.padding == false) {
                body_style.push('padding: 0px;');
            }
            body_style.push('overflow: ' + this.options.overflow + ';');


            template += '	  <div class="modal-body" style="' + body_style.join('') + '">'
            template += this.content;
            template += '	  </div>'
            if (!underScore.isEmpty(this.buttons)) {
                template += '	  <div class="modal-footer">'
                underScore.each(this.buttons, function (button, name) {
                    var icon = '';

                    if (!underScore.isEmpty(button.icon)) {
                        icon = '<i class="fa fa-' + button.icon + '"></i>';
                    }
                    if (button.is_default) {
                        default_button_name = name;
                    }

                    template += '<button type="button" class="btn btn-' + button.type + '"';
                    template += ' onclick="App.WaiterSystem.runWaiter(\'' + instance.button_click_waiter + '\', \'' + name + '\')" >' + icon + button.label + '</button>'
                });

                template += '	  </div>'
            }

            template += '	</div>'
            template += '  </div>'
            template += '</div>'

            $('body').append(template);
            $('body').data('dialogs', dialogs + 1);

            underScore.each(['show', 'shown', 'hide', 'hidden'], function (status) {
                instance.setModalEvent(status, function () {
                    instance.status = status;
                }, App.Priority.lowest_priority);
            });
            underScore.each(this.events, function (priority, event) {
                var handlers = priority.getContents();

                if (underScore.isArray(handlers) && !underScore.isEmpty(handlers)) {
                    underScore.each(handlers, function (handler) {
                        var waiter_key = App.WaiterSystem.addWaiter(handler, true, 'Modal: ' + dialog_id + ' > Event: ' + event);
                        waiter_keys.push(waiter_key);
                        $('#' + dialog_id).on(event + '.bs.modal', function (e) {
                            App.WaiterSystem.runWaiter(waiter_key, {modal_id: dialog_id, event: e});
                        });
                    });
                }
            });


            $('#' + dialog_id).on('hidden.bs.modal', function () {
                var dialogs = $('body').data('dialogs') || 1; //Số dialog hiện đang mở

                //Ánh xạ button mặc định khi thoát mà không click vào button
                if (!underScore.isEmpty(instance.buttons) && !instance.clicked && !underScore.isUndefined(default_button_name)) {
                    App.WaiterSystem.runWaiter(instance.button_click_waiter, default_button_name);
                }

                //Gỡ các waiter key
                underScore.each(waiter_keys, function (waiter) {
                    App.WaiterSystem.removeWaiter(waiter);
                });
                App.WaiterSystem.removeWaiter(instance.button_click_waiter);

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
    var init_contents = new App.Priority();

    App.addInitCommand = function (command, priority) {
        init_contents.addContent(command, priority);
    };
    App.init = function () {
        var commands = init_contents.getContents();
        for (var i in commands) {
            App.Helper.callFunctionDynamic(commands[i]);
        }
    };


    /********************************************************
     *  App jQuery plugin
     ********************************************************/


    /**
     * App Ajax Form jQuery plugin
     */
    App.addInitCommand(function () {
        (function ($) {
            $.fn.sMAjaxForm = function (options) {
                var settings = {
                    disable_on_send: true,
                    status_selector: 'input[type="submit"], button[type="submit"]',
                    sending_content: 'Đang gửi',
                };
                if (typeof options == 'object') {
                    settings = $.extend(settings, options);
                }
                var form = $(this);
                var target_button = form.find(settings.status_selector);
                var aw = new App.AJAXWorker();
                if (form.find('div.process_info').length == 0) {
                    form.prepend($('<div class="process_info"></div>'));
                }
                var info_element = form.find('div.process_info');
                var old_label = target_button.html();

                form.submit(function (event) {
                    aw.option({
                        requestPath: form.prop('action') || window.location.href,
                        requestData: App.DOM.getFormInputValue(form),
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
                            if (data instanceof App.ProcessResult) {
                                info_element.html('');
                                underScore.each(data.getInfos(), function (info) {
                                    info_element.append(App.Template.bootstrapAlert(info.content, info.type));
                                });
                                if (data.hasData('new_form_data')) {
                                    console.log('Assign new data', data.getData('new_form_data'));
                                    console.log('RESULT', App.DOM.assignFormData(form, data.getData('new_form_data'), null));
                                } else {
                                    console.log('Ko co data moi');
                                }
                                App.Helper.progressAjaxAction(data.getActions());
                            }
                        },
                        errorFunc: function (data) {
                            console.log('Error', data);
                            if (data instanceof App.ProcessResult) {
                                info_element.html('');
                                underScore.each(data.getInfos(), function (info) {
                                    info_element.append(App.Template.bootstrapAlert(info.content, info.type));
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