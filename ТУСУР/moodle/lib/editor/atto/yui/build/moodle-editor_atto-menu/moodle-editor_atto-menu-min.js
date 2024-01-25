YUI.add("moodle-editor_atto-menu",function(n,e){var t=function(){t.superclass.constructor.apply(this,arguments)};n.extend(t,M.core.dialogue,{_menuHandlers:null,_menuButton:null,initializer:function(e){var t;this._menuHandlers=[],this._menuButton=document.getElementById(e.buttonId),t=n.Handlebars.compile('<div class="open {{config.buttonClass}} atto_menu" style="min-width:{{config.innerOverlayWidth}};"><ul class="dropdown-menu" role="menu" id="{{config.buttonId}}_menu" aria-labelledby="{{config.buttonId}}">{{#each config.items}}<li role="none" class="atto_menuentry"><a href="#" role="menuitem" data-index="{{@index}}" {{#each data}}data-{{@key}}="{{this}}"{{/each}}>{{{text}}}</a></li>{{/each}}</ul></div>'),e=n.Node.create(t({config:e})),this.set("bodyContent",e),(t=this.get("boundingBox")).addClass("editor_atto_controlmenu"),t.addClass("editor_atto_menu"),(e=t.one(".moodle-dialogue-wrap")).removeClass("moodle-dialogue-wrap").addClass("moodle-dialogue-content"),e.removeAttribute("role"),e.removeAttribute("aria-labelledby"),(t=this.get("headerText").trim())&&(e=n.Node.create("<h3/>").addClass("accesshide").setHTML(t),this.get("bodyContent").prepend(e)),this.headerNode.hide(),this.footerNode.hide(),this._setupHandlers()},_setupHandlers:function(){var e=this.get("contentBox");this._menuHandlers.push(e.delegate("key",this._chooseMenuItem,"32, enter",".atto_menuentry",this),e.delegate("key",this._handleKeyboardEvent,"down:38,40",".dropdown-menu",this),e.on("focusoutside",this.hide,this),e.delegate("key",this.hide,"down:37,39,esc",".dropdown-menu",this))},_chooseMenuItem:function(e){e.target.simulate("click"),e.preventDefault()},hide:function(e){if(!0!==this.get("preventHideMenu"))return e&&e.preventDefault(),this._menuButton&&this._menuButton.removeAttribute("aria-expanded"),t.superclass.hide.call(this,arguments)},_handleKeyboardEvent:function(e){var t,n,o,a,i,d,s;for(e.preventDefault(),t=e.currentTarget.all('a[role="menuitem"]'),n=!1,a=1,d=e.target.ancestor('a[role="menuitem"]',!(i=o=0));!n&&o<t.size();)t.item(o)===d?n=!0:o++;if(n){for(38===e.keyCode&&(a=-1);(o+=a)<0?o=t.size()-1:o>=t.size()&&(o=0),s=t.item(o),++i<t.size()&&s!==d&&s.hasAttribute("hidden"););s&&s.focus(),e.preventDefault(),e.stopImmediatePropagation()}}},{NAME:"menu",ATTRS:{headerText:{value:""}}}),n.Base.modifyAttrs(t,{width:{value:"auto"},hideOn:{value:[{eventName:"clickoutside"}]},extraClasses:{value:["editor_atto_menu"]},responsive:{value:!1},visible:{value:!1},center:{value:!1},closeButton:{value:!1}}),n.namespace("M.editor_atto").Menu=t},"@VERSION@",{requires:["moodle-core-notification-dialogue","node","event","event-custom"]});