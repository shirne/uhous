var dialog=window.parent;var oEditor=dialog.InnerDialogLoaded();var FCK=oEditor.FCK;var FCKLang=oEditor.FCKLang;var FCKConfig=oEditor.FCKConfig;var FCKDebug=oEditor.FCKDebug;var FCKTools=oEditor.FCKTools;var bImageButton=(document.location.search.length>0&&document.location.search.substr(1)=="ImageButton");dialog.AddTab("Info",FCKLang.DlgImgInfoTab);if(!bImageButton&&!FCKConfig.ImageDlgHideLink){dialog.AddTab("Link",FCKLang.DlgImgLinkTab)}if(FCKConfig.ImageUpload){dialog.AddTab("Upload",FCKLang.DlgLnkUpload)}if(!FCKConfig.ImageDlgHideAdvanced){dialog.AddTab("Advanced",FCKLang.DlgAdvancedTag)}function OnDialogTabChange(a){ShowE("divInfo",(a=="Info"));ShowE("divLink",(a=="Link"));ShowE("divUpload",(a=="Upload"));ShowE("divAdvanced",(a=="Advanced"))}var oImage=dialog.Selection.GetSelectedElement();if(oImage&&oImage.tagName!="IMG"&&!(oImage.tagName=="INPUT"&&oImage.type=="image")){oImage=null}var oLink=dialog.Selection.GetSelection().MoveToAncestorNode("A");var oImageOriginal;function UpdateOriginal(a){if(!eImgPreview){return}if(GetE("txtUrl").value.length==0){oImageOriginal=null;return}oImageOriginal=document.createElement("IMG");if(a){oImageOriginal.onload=function(){this.onload=null;ResetSizes()}}oImageOriginal.src=eImgPreview.src}var bPreviewInitialized;window.onload=function(){oEditor.FCKLanguageManager.TranslatePage(document);GetE("btnLockSizes").title=FCKLang.DlgImgLockRatio;GetE("btnResetSize").title=FCKLang.DlgBtnResetSize;LoadSelection();GetE("tdBrowse").style.display=FCKConfig.ImageBrowser?"":"none";GetE("divLnkBrowseServer").style.display=FCKConfig.LinkBrowser?"":"none";UpdateOriginal();if(FCKConfig.ImageUpload){GetE("frmUpload").action=FCKConfig.ImageUploadURL}dialog.SetAutoSize(true);dialog.SetOkButton(true);SelectField("txtUrl")};function LoadSelection(){if(!oImage){return}var d=oImage.getAttribute("_fcksavedurl");if(d==null){d=GetAttribute(oImage,"src","")}GetE("txtUrl").value=d;GetE("txtAlt").value=GetAttribute(oImage,"alt","");GetE("txtVSpace").value=GetAttribute(oImage,"vspace","");GetE("txtHSpace").value=GetAttribute(oImage,"hspace","");GetE("txtBorder").value=GetAttribute(oImage,"border","");GetE("cmbAlign").value=GetAttribute(oImage,"align","");var f,g;var c=/^\s*(\d+)px\s*$/i;if(oImage.style.width){var b=oImage.style.width.match(c);if(b){f=b[1];oImage.style.width="";SetAttribute(oImage,"width",f)}}if(oImage.style.height){var e=oImage.style.height.match(c);if(e){g=e[1];oImage.style.height="";SetAttribute(oImage,"height",g)}}GetE("txtWidth").value=f?f:GetAttribute(oImage,"width","");GetE("txtHeight").value=g?g:GetAttribute(oImage,"height","");GetE("txtAttId").value=oImage.id;GetE("cmbAttLangDir").value=oImage.dir;GetE("txtAttLangCode").value=oImage.lang;GetE("txtAttTitle").value=oImage.title;GetE("txtLongDesc").value=oImage.longDesc;if(oEditor.FCKBrowserInfo.IsIE){GetE("txtAttClasses").value=oImage.className||"";GetE("txtAttStyle").value=oImage.style.cssText}else{GetE("txtAttClasses").value=oImage.getAttribute("class",2)||"";GetE("txtAttStyle").value=oImage.getAttribute("style",2)}if(oLink){var a=oLink.getAttribute("_fcksavedurl");if(a==null){a=oLink.getAttribute("href",2)}GetE("txtLnkUrl").value=a;GetE("cmbLnkTarget").value=oLink.target}UpdatePreview()}function Ok(){if(GetE("txtUrl").value.length==0){dialog.SetSelectedTab("Info");GetE("txtUrl").focus();alert(FCKLang.DlgImgAlertUrl);return false}var a=(oImage!=null);if(a&&bImageButton&&oImage.tagName=="IMG"){if(confirm("Do you want to transform the selected image on a image button?")){oImage=null}}else{if(a&&!bImageButton&&oImage.tagName=="INPUT"){if(confirm("Do you want to transform the selected image button on a simple image?")){oImage=null}}}oEditor.FCKUndo.SaveUndoStep();if(!a){if(bImageButton){oImage=FCK.EditorDocument.createElement("input");oImage.type="image";oImage=FCK.InsertElement(oImage)}else{oImage=FCK.InsertElement("img")}}UpdateImage(oImage);var b=GetE("txtLnkUrl").value.Trim();if(b.length==0){if(oLink){FCK.ExecuteNamedCommand("Unlink")}}else{if(oLink){oLink.href=b}else{if(!a){oEditor.FCKSelection.SelectNode(oImage)}oLink=oEditor.FCK.CreateLink(b)[0];if(!a){oEditor.FCKSelection.SelectNode(oLink);oEditor.FCKSelection.Collapse(false)}}SetAttribute(oLink,"_fcksavedurl",b);SetAttribute(oLink,"target",GetE("cmbLnkTarget").value)}return true}function UpdateImage(a,b){a.src=GetE("txtUrl").value;SetAttribute(a,"_fcksavedurl",GetE("txtUrl").value);SetAttribute(a,"alt",GetE("txtAlt").value);SetAttribute(a,"width",GetE("txtWidth").value);SetAttribute(a,"height",GetE("txtHeight").value);SetAttribute(a,"vspace",GetE("txtVSpace").value);SetAttribute(a,"hspace",GetE("txtHSpace").value);SetAttribute(a,"border",GetE("txtBorder").value);SetAttribute(a,"align",GetE("cmbAlign").value);if(!b){SetAttribute(a,"id",GetE("txtAttId").value)}SetAttribute(a,"dir",GetE("cmbAttLangDir").value);SetAttribute(a,"lang",GetE("txtAttLangCode").value);SetAttribute(a,"title",GetE("txtAttTitle").value);SetAttribute(a,"longDesc",GetE("txtLongDesc").value);if(oEditor.FCKBrowserInfo.IsIE){a.className=GetE("txtAttClasses").value;a.style.cssText=GetE("txtAttStyle").value}else{SetAttribute(a,"class",GetE("txtAttClasses").value);SetAttribute(a,"style",GetE("txtAttStyle").value)}}var eImgPreview;var eImgPreviewLink;function SetPreviewElements(b,a){eImgPreview=b;eImgPreviewLink=a;UpdatePreview();UpdateOriginal();bPreviewInitialized=true}function UpdatePreview(){if(!eImgPreview||!eImgPreviewLink){return}if(GetE("txtUrl").value.length==0){eImgPreviewLink.style.display="none"}else{UpdateImage(eImgPreview,true);if(GetE("txtLnkUrl").value.Trim().length>0){eImgPreviewLink.href="javascript:void(null);"}else{SetAttribute(eImgPreviewLink,"href","")}eImgPreviewLink.style.display=""}}var bLockRatio=true;function SwitchLock(a){bLockRatio=!bLockRatio;a.className=bLockRatio?"BtnLocked":"BtnUnlocked";a.title=bLockRatio?"Lock sizes":"Unlock sizes";if(bLockRatio){if(GetE("txtWidth").value.length>0){OnSizeChanged("Width",GetE("txtWidth").value)}else{OnSizeChanged("Height",GetE("txtHeight").value)}}}function OnSizeChanged(c,a){if(oImageOriginal&&bLockRatio){var b=c=="Width"?GetE("txtHeight"):GetE("txtWidth");if(a.length==0||isNaN(a)){b.value="";return}if(c=="Width"){a=a==0?0:Math.round(oImageOriginal.height*(a/oImageOriginal.width))}else{a=a==0?0:Math.round(oImageOriginal.width*(a/oImageOriginal.height))}if(!isNaN(a)){b.value=a}}UpdatePreview()}function ResetSizes(){if(!oImageOriginal){return}if(oEditor.FCKBrowserInfo.IsGecko&&!oImageOriginal.complete){setTimeout(ResetSizes,50);return}GetE("txtWidth").value=oImageOriginal.width;GetE("txtHeight").value=oImageOriginal.height;UpdatePreview()}function BrowseServer(){OpenServerBrowser("Image",FCKConfig.ImageBrowserURL,FCKConfig.ImageBrowserWindowWidth,FCKConfig.ImageBrowserWindowHeight)}function LnkBrowseServer(){OpenServerBrowser("Link",FCKConfig.LinkBrowserURL,FCKConfig.LinkBrowserWindowWidth,FCKConfig.LinkBrowserWindowHeight)}function OpenServerBrowser(d,b,c,a){sActualBrowser=d;OpenFileBrowser(b,c,a)}var sActualBrowser;function SetUrl(b,c,a,d){if(sActualBrowser=="Link"){GetE("txtLnkUrl").value=b;UpdatePreview()}else{GetE("txtUrl").value=b;GetE("txtWidth").value=c?c:"";GetE("txtHeight").value=a?a:"";if(d){GetE("txtAlt").value=d}UpdatePreview();UpdateOriginal(true)}dialog.SetSelectedTab("Info")}function OnUploadCompleted(c,a,d,b){window.parent.Throbber.Hide();GetE("divUpload").style.display="";switch(c){case 0:alert("Your file has been successfully uploaded");break;case 1:alert(b);return;case 101:alert(b);break;case 201:alert('A file with the same name is already available. The uploaded file has been renamed to "'+d+'"');break;case 202:alert("Invalid file type");return;case 203:alert("Security error. You probably don't have enough permissions to upload. Please check your server.");return;case 500:alert("The connector is disabled");break;default:alert("Error on file upload. Error number: "+c);return}sActualBrowser="";SetUrl(a);GetE("frmUpload").reset()}var oUploadAllowedExtRegex=new RegExp(FCKConfig.ImageUploadAllowedExtensions,"i");var oUploadDeniedExtRegex=new RegExp(FCKConfig.ImageUploadDeniedExtensions,"i");function CheckUpload(){var a=GetE("txtUploadFile").value;if(a.length==0){alert("Please select a file to upload");return false}if((FCKConfig.ImageUploadAllowedExtensions.length>0&&!oUploadAllowedExtRegex.test(a))||(FCKConfig.ImageUploadDeniedExtensions.length>0&&oUploadDeniedExtRegex.test(a))){OnUploadCompleted(202);return false}window.parent.Throbber.Show(100);GetE("divUpload").style.display="none";return true};
