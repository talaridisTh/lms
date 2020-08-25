ArticleEditor.add('plugin', 'specialchars', {
    translations: {
        en: {
            "specialchars": {
                "special-chars": "Special Characters"
            }
        }
    },
    defaults: {
        icon: '<svg height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg"><path d="m2 14v-1.8348348h2.38016529v-.0780781c-.99173554-.975976-2.10247934-2.67417419-2.10247934-4.99699701 0-3.57207207 2.28099174-6.09009009 5.73223141-6.09009009 3.43140494 0 5.71239664 2.51801802 5.71239664 6.09009009 0 2.32282282-1.1107438 4.02102101-2.1024793 4.99699701v.0780781h2.3801653v1.8348348h-4.95867769v-1.6396396c1.40826449-1.1906907 2.32066119-2.75225229 2.32066119-5.07507511 0-2.4984985-1.2495868-4.31381382-3.35206614-4.31381382s-3.37190083 1.81531532-3.37190083 4.31381382c0 2.32282282.91239669 3.88438441 2.32066116 5.07507511v1.6396396z"/></svg>',
        items: [
            '&lsquo;', '&rsquo;', '&ldquo;', '&rdquo;', '&ndash;', '&mdash;', '&divide;', '&hellip;', '&trade;', '&bull;',
        	'&rarr;', '&asymp;', '$', '&euro;', '&cent;', '&pound;', '&yen;', '&iexcl;',
        	'&curren;', '&brvbar;', '&sect;', '&uml;', '&copy;', '&ordf;', '&laquo;', '&raquo;', '&not;', '&reg;', '&macr;',
        	'&deg;', '&sup1;', '&sup2;', '&sup3;', '&acute;', '&micro;', '&para;', '&middot;', '&cedil;',  '&ordm;',
        	'&frac14;', '&frac12;', '&frac34;', '&iquest;', '&Agrave;', '&Aacute;', '&Acirc;', '&Atilde;', '&Auml;', '&Aring;',
        	'&AElig;', '&Ccedil;', '&Egrave;', '&Eacute;', '&Ecirc;', '&Euml;', '&Igrave;', '&Iacute;', '&Icirc;', '&Iuml;',
        	'&ETH;', '&Ntilde;', '&Ograve;', '&Oacute;', '&Ocirc;', '&Otilde;', '&Ouml;', '&times;', '&Oslash;', '&Ugrave;',
        	'&Uacute;', '&Ucirc;', '&Uuml;', '&Yacute;', '&THORN;', '&szlig;', '&agrave;', '&aacute;', '&acirc;', '&atilde;',
        	'&auml;', '&aring;', '&aelig;', '&ccedil;', '&egrave;', '&eacute;', '&ecirc;', '&euml;', '&igrave;', '&iacute;',
        	'&icirc;', '&iuml;', '&eth;', '&ntilde;', '&ograve;', '&oacute;', '&ocirc;', '&otilde;', '&ouml;',
        	'&oslash;', '&ugrave;', '&uacute;', '&ucirc;', '&uuml;', '&yacute;', '&thorn;', '&yuml;', '&OElig;', '&oelig;',
        	'&#372;', '&#374', '&#373', '&#375;'
        ]
    },
    start: function() {
        this.app.toolbar.add('specialchars', {
            title: '## specialchars.special-chars ##',
            icon: this.opts.specialchars.icon,
            command: 'specialchars.popup',
            blocks: {
                all: 'editable',
                except: ['code']
            }
        });
    },
    popup: function(params, button) {
        var items = {};
        var chars = this.opts.specialchars.items;

        for (var i = 0; i < chars.length; i++) {
            items[i] = {
                html: this.dom('<div>').addClass(this.prefix + '-popup-item').html(chars[i]),
                command: 'specialchars.insert',
                params: {
                    character: chars[i]
                }
            };
        }


        this.app.popup.create('specialchars', {
            type: 'grid',
            width: '352px',
            items: items
        });
        this.app.popup.open({ button: button });
    },
    insert: function(params) {
        this.app.popup.close();
        this.app.insertion.insertHtml(params.character, 'after');
    }
});