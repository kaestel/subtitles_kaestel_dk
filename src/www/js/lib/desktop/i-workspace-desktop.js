Util.Objects["translation"] = new function() {
	this.init = function(scene) {

		scene.hN = u.qs(".header", scene);
		scene.project_name = u.qs("#project_name", scene).value;

		scene.nodes = u.qsa(".section", scene);


		scene.original_language = u.qs(".subtitle select", scene.hN);
		scene.original_language.scene = scene;
		scene.original_language.onchange = function() {
			this.scene.autosave();
		}
		scene.translation_language = u.qs(".translation select", scene.hN);
		scene.translation_language.scene = scene;
		scene.translation_language.onchange = function() {
			this.scene.autosave();
		}



		// index section
		for(i = 0; node = scene.nodes[i]; i++) {

			node.scene = scene;

			node._index = u.qs(".index", node);
			node._index.node = node;

			node._start = u.qs(".start input", node);
			node._start.node = node;
			node._start.onchange = function() {
				this.node.scene.autosave();
			}
			

			node._end = u.qs(".end input", node);
			node._end.node = node;
			node._end.onchange = function() {
				this.node.scene.autosave();
			}

			node._subtitle = u.qs(".subtitle textarea", node);
			node._subtitle.node = node;
			node._subtitle.onchange = function() {
				this.node.scene.autosave();
			}

			node._translation = u.qs(".translation textarea", node);
			node._translation.node = node;
			node._translation.onchange = function() {
				this.node.scene.autosave();
			}

			// add tools
			node.tools = u.ae(node, "ul", {"class":"tools"});

			// add delete button
			node.bn_delete = u.ae(node.tools, "li", {"class":"delete", "html":"Delete"});
			node.bn_delete.node = node;

			u.e.click(node.bn_delete);
			node.bn_delete.clicked = function() {
				this.node.scene.deleteNode(this.node);
			}

			node.bn_translate = u.ae(node.tools, "li", {"class":"translate", "html":"Translate"});
			node.bn_translate.node = node;

			u.e.click(node.bn_translate);
			node.bn_translate.clicked = function() {
				this.node.scene.translateNode(this.node);
			}

		}


		// loop through all sections and update indexes
		scene.deleteNode = function(node) {
			node.parentNode.removeChild(node);
			this.autosave();
		}

		// request google translation and insert into translation textarea
		scene.translateNode = function(node) {
			
			if(this.original_language.selectedIndex == 0 || this.translation_language.selectedIndex == 0) {
				window.scrollTo(0, 0);

				alert("select language first");
			}
			else {
				node.response = function(response) {
					this._translation.value = u.qs("#translation", response).innerHTML;

					this.scene.autosave();
				}

				u.request(node, "/translate/" + this.original_language.options[this.original_language.selectedIndex].value + "/" + this.translation_language.options[this.translation_language.selectedIndex].value, {"params":"text="+node._subtitle.value.replace("\n", " "), "method":"post"});
			}
		}


		// auto save all information
		scene.autosave = function() {
			u.bug("auto save")

			if(this.original_language.selectedIndex == 0 || this.translation_language.selectedIndex == 0) {

				alert("select language first");

			}
			else {

				var params = "";
				params += "project_name="+this.project_name+"&";
				params += "original_language="+this.original_language.options[this.original_language.selectedIndex].value+"&";
				params += "translation_language="+this.translation_language.options[this.translation_language.selectedIndex].value+"&";

				sections = [];
				this.nodes = u.qsa(".section", this);
				for(i = 0; node = this.nodes[i]; i++) {
					sections.push([node._start.value, node._end.value, node._subtitle.value, node._translation.value]);
				}
				params += "sections=" + JSON.stringify(sections);

				scene.response = function(response) {
				
				}

				u.request(this, "/autosave", {"params":params, "method":"post"});

			}


		}

	}
}