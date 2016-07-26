{{ include file='layouts/head.tpl' }}

<div class="inner-content">

{{ if $product.pro_id }}

    {{ assign var='label' value='编辑商品' }}

{{ else }}

    {{ assign var='label' value='添加商品' }}

{{ /if }}

{{ webcontrol type='Position' name='position' column='栏目管理' position=$label footprint='yes' }}

{{ assign var='cmdType' value='products' }}

{{ include file='modules/products/cmd.tpl' }}
<style type="text/css">
.item{border:1px #ccc solid}
.item thead tr.head{background:#DCE4D9}
.item thead a{padding:0 5px;margin:0 10px}
.item thead td{padding-left:10px;}
.item tbody tr{}
</style>
<div class="layout clearfix">

        <div class="box">
            <h3>{{$label}}</h3>
            <div class="form">

                <form id="editform" name="editform" action="{{ url controller='Products' action='Save' }}" method="post" enctype="multipart/form-data">
                    <table>
                        <tr>
                            <td style="width: 50%;">
                                <p>
                                    <label for="cate_id">所属分类:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <select id="cate_id" name="cate_id">
{{ foreach from=$categories item=cate }}
{{ if $cate.children }}
    <optgroup label="{{$cate.name}}">
    {{ foreach from=$cate.children item=child }}
        <option value="{{$child.cate_id}}"{{ if $product.cate_id == $child.cate_id }} selected="selected"{{ /if }}>{{$child.name}}</option>
    {{ /foreach }}
    </optgroup>
{{ else }}
    <option value="{{$cate.cate_id}}"{{ if $product.cate_id == $cate.cate_id }} selected="selected"{{ /if }}>{{$cate.name}}</option>
{{ /if }}
{{ /foreach }}
                                    </select>
                                    </b></b>
                                </p>
                            </td>
                            <td style="width: 5%;"></td>
                            <td style="width: 45%;">
                                <p>
                                    <label for="brand_id">所属品牌:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <select id="brand_id" name="brand_id">
{{ foreach from=$brands item=brand }}
    <option value="{{$brand.brand_id}}"{{ if $product.brand_id == $brand.brand_id}} selected="selected"{{ /if }}>{{$brand.name}}</option>
{{ /foreach }}
                                    </select>
                                    </b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="displayorder">商品属性:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner">
                                    <select id="displayorder" name="displayorder">
                                        <option value="1"{{ if $product.displayorder == 1 }} selected="selected"{{ /if }}>普通商品</option>
                                        <option value="2"{{ if $product.displayorder == 2 }} selected="selected"{{ /if }}>最新商品</option>
                                        <option value="3"{{ if $product.displayorder == 3 }} selected="selected"{{ /if }}>热门商品</option>
                                        <option value="4"{{ if $product.displayorder == 4 }} selected="selected"{{ /if }}>推荐商品</option>
                                    </select>
                                    </b></b>
                                </p>
                            </td>
                            <td></td>
                            <td>
                                <p>
                                    <label for="selled">购买次数:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="selled" name="selled" value="{{$product.selled}}" /></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="name">商品名称:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="name" name="name" value="{{$product.name}}" /></b></b>
                                    <small>* 必填</small>
                                </p>
                            </td>
                            <td></td>
                            <td>
                                <p>
                                    <label for="price">商品单价:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="price" name="price" value="{{$product.price}}" /></b></b>
                                    <small>(￥) * 必填</small>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="color">颜色:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="color" name="color" value="{{$product.color}}" /></b></b>
                                </p>
                            </td>
                            <td></td>
                            <td>
                                <p>
                                    <label for="size">尺寸:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="size" name="size" value="{{$product.size}}" /></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                        	<td colspan="3">
                        		<table id="sizeTable" class="item">
                        			<thead>
                        				<tr class="head">
                        					<td colspan="2"><a href="javascript:void(removeSize())" style="float:right">删除</a><a href="javascript:void(addSize())" style="float:right">添加</a>尺寸</td>
                        				</tr>
                        				<tr>
                        					<td>项目</td>
                        					<td>内容</td>
                        				</tr>
                        			</thead>
                        			<tbody>
	                        			<script type="text/javascript">
                        				var sizeCount=0;
                        				</script>
                        				{{foreach from=$product.params.size item="size" key="k"}}
                        				<tr>
                        					<td><b class="fluid-input"><b class="fluid-input-inner"><input type="text" class="fluid-input" name="params[size][{{$k}}][title]" value="{{$size.title}}" /></b></b></td>
                        					<td><b class="fluid-input"><b class="fluid-input-inner"><input type="text" class="fluid-input" name="params[size][{{$k}}][content]" value="{{$size.content}}" /></b></b></td>
                        				</tr>
                        				<script type="text/javascript">
                        				var sizeCount={{$k}}+1;
                        				</script>
                        				{{/foreach}}
                        			</tbody>
                        		</table>
                        	</td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="procode">商品型号:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="procode" name="procode" value="{{$product.procode}}" /></b></b>
                                </p>
                            </td>
                            <td></td>
                            <td>
                                <p>
                                    <label for="retail">市场零售价:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="retail" name="retail" value="{{$product.retail}}" /></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="delivery_cost">所需运费:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="delivery_cost" name="delivery_cost" value="{{$product.delivery_cost}}" /></b></b>
                                </p>
                            </td>
                            <td></td>
                            <td>
                                <p>
                                    <label for="discount">折扣:</label>
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="text" id="discount" name="discount" value="{{$product.discount|default:0}}" /></b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <input name='params[intro][1][title]' value="{{ if $product.params.intro.1.title}}{{$product.params.intro.1.title}} {{else}}完美制造{{/if}}" style="border:1px solid #CCC; background: white; font-size: 12px; height: 25px; line-height:25px;" />
                                    {{ if $product.params.intro.1.pic }}
                                    <input type="hidden" name="params[intro][1][pic]" value="{{$product.params.intro.1.pic}}" />
                                    <img src="/{{ get_app_inf key='uploadDir' }}thumb_{{$product.params.intro.1.pic}}" height="32" />
                                        <a href="/{{ get_app_inf key='uploadDir' }}{{$product.params.intro.1.pic}}" target="_blank">查看原图</a> | <a href="{{ url controller='Products' action='RemovePic' id=$product.pro_id witch='params.intro.1.pic' }}">删除图片</a>
                                    {{ else }}
                                    <input type="file" name="params_intro_1_pic" />
                                    {{ /if }}
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='memo' name='params[intro][1][content]' value=$product.params.intro.1.content class='itext' }}</b></b>
                                </p>
                            </td>
                            <td></td>
                            <td>
                                <p>

                                    <input name='params[intro][2][title]' value="{{ if $product.params.intro.2.title}}{{$product.params.intro.2.title}} {{else}}设计风格{{/if}}" style="border: 1px solid #ccc; background: white; font-size: 12px; height: 25px; line-height:25px;" />
                                    {{ if $product.params.intro.2.pic }}
                                    <input type="hidden" name="params[intro][2][pic]" value="{{$product.params.intro.2.pic}}" />
                                    <img src="/{{ get_app_inf key='uploadDir' }}thumb_{{$product.params.intro.2.pic}}" height="32" />
                                        <a href="/{{ get_app_inf key='uploadDir' }}{{$product.params.intro.2.pic}}" target="_blank">查看原图</a> | <a href="{{ url controller='Products' action='RemovePic' id=$product.pro_id witch='params.intro.2.pic' }}">删除图片</a>
                                    {{ else }}
                                    <input type="file" name="params_intro_2_pic" />
                                    {{ /if }}
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='memo' name='params[intro][2][content]' value=$product.params.intro.2.content class='itext' }}</b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <input name='params[intro][3][title]' value="{{ if $product.params.intro.3.title}}{{$product.params.intro.3.title}} {{else}}豪华舒适{{/if}}" style="border: 1px solid #ccc; background: white; font-size: 12px; height: 25px; line-height:25px;" />
                                    {{ if $product.params.intro.3.pic }}
                                    <input type="hidden" name="params[intro][3][pic]" value="{{$product.params.intro.3.pic}}" />
                                    <img src="/{{ get_app_inf key='uploadDir' }}thumb_{{$product.params.intro.3.pic}}" height="32" />
                                        <a href="/{{ get_app_inf key='uploadDir' }}{{$product.params.intro.3.pic}}" target="_blank">查看原图</a> | <a href="{{ url controller='Products' action='RemovePic' id=$product.pro_id witch='params.intro.3.pic' }}">删除图片</a>
                                    {{ else }}
                                    <input type="file" name="params_intro_3_pic" />
                                    {{ /if }}
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='memo' name='params[intro][3][content]' value=$product.params.intro.3.content class='itext' }}</b></b>
                                </p>
                            </td>
                            <td></td>
                            <td>
                                <p>
                                    <input name='params[intro][4][title]' value="{{ if $product.params.intro.4.title}}{{$product.params.intro.4.title}} {{else}}社会荣誉{{/if}}" style="border: 1px solid #ccc; background: white; font-size: 12px; height: 25px; line-height:25px;" />
                                    {{ if $product.params.intro.4.pic }}
                                    <input type="hidden" name="params[intro][4][pic]" value="{{$product.params.intro.4.pic}}" />
                                    <img src="/{{ get_app_inf key='uploadDir' }}thumb_{{$product.params.intro.4.pic}}" height="32" />
                                        <a href="/{{ get_app_inf key='uploadDir' }}{{$product.params.intro.4.pic}}" target="_blank">查看原图</a> | <a href="{{ url controller='Products' action='RemovePic' id=$product.pro_id witch='params.intro.4.pic' }}">删除图片</a>
                                    {{ else }}
                                    <input type="file" name="params_intro_4_pic" />
                                    {{ /if }}
                                    <b class="fluid-input"><b class="fluid-input-inner">{{ webcontrol type='memo' name='params[intro][4][content]' value=$product.params.intro.4.content class='itext' }}</b></b>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    <label for="pic">商品缩略图:</label>
{{ if $product.pic }}
                                    <div>
                                        <img src="/{{ get_app_inf key='uploadDir' }}thumb_{{$product.pic}}" height="32" />
                                        <a href="/{{ get_app_inf key='uploadDir' }}{{$product.pic}}" target="_blank">查看原图</a> | <a href="{{ url controller='Products' action='RemovePic' id=$product.pro_id witch='pic' }}">删除图片</a>
                                    </div>
                                    <small>如需要重新上传图片，须先删除图片。</small>
{{ else }}
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="file" id="pic" name="pic" /></b></b>
                                    <small>图片尺寸：210px X 158px (像素)。</small>
{{ /if }}
                                </p>
                            </td>
                            <td></td>
                            <td>
                                <p>
                                    <label for="thumb_pic">商品大图:</label>
{{ if $product.thumb_pic }}
                                    <div>
                                        <img src="/{{ get_app_inf key='uploadDir' }}thumb_{{$product.thumb_pic}}" height="32" />
                                        <a href="/{{ get_app_inf key='uploadDir' }}{{$product.thumb_pic}}" target="_blank">查看原图</a> | <a href="{{ url controller='Products' action='RemovePic' id=$product.pro_id witch='thumb_pic' }}">删除图片</a>
                                    </div>
                                    <small>如需要重新上传图片，须先删除图片。</small>
{{ else }}
                                    <b class="fluid-input"><b class="fluid-input-inner"><input class="itext" type="file" id="thumb_pic" name="thumb_pic" /></b></b>
                                    <small>图片尺寸：958px X 500px (像素)。</small>
{{ /if }}
                                </p>
                            </td>
                        </tr>
                        <tr>
                        	<td colspan="3">
                        		<table id="memoTable" class="item">
                        			<thead>
                        				<tr class="head">
                        					<td colspan="2"><a href="javascript:void(removeMemo())" style="float:right">删除</a><a href="javascript:void(addMemo())" style="float:right">添加</a>商品描述</td>
                        				</tr>
                        				<tr>
                        					<td>项目</td>
                        					<td>内容</td>
                        				</tr>
                        			</thead>
                        			<tbody>
	                        			<script type="text/javascript">
                        				var memoCount=0;
                        				</script>
                        				{{foreach from=$product.params.memo item="memo" key="k"}}
                        				<tr>
                        					<td><b class="fluid-input"><b class="fluid-input-inner"><input type="text" class="fluid-input" name="params[memo][{{$k}}][title]" value="{{$memo.title}}" /></b></b></td>
                        					<td><b class="fluid-input"><b class="fluid-input-inner"><input type="text" class="fluid-input" name="params[memo][{{$k}}][content]" value="{{$memo.content}}" /></b></b></td>
                        				</tr>
                        				<script type="text/javascript">
                        				var memoCount={{$k}}+1;
                        				</script>
                        				{{/foreach}}
                        			</tbody>
                        		</table>
                        	</td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <p>
                                    <fieldset class="fold">
                                        <legend>SEO相关</legend>
                                        <div>
                                            <label for="seo_title">网站标题:</label>
                                            <b class="fluid-input"><b class="fluid-input-inner">
                                                <input type="text" class="itext" name='seo_title' id="seo_title" value="{{$product.seo_title}}" />
                                            </b></b><br />

                                            <label for="keyword">关键字:</label>
                                            <b class="fluid-input"><b class="fluid-input-inner">
                                            {{ webcontrol type='memo' class="itext" name='keyword' value=$product.keyword height='100' }}
                                            </b></b><br />

                                            <label for="description">网站描述:</label>
                                            <b class="fluid-input"><b class="fluid-input-inner">
                                            {{ webcontrol type='memo' class="itext" name='description' value=$product.description height='150' }}
                                            </b></b>
                                        </div>
                                    </fieldset>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <p>
                                    <input class="ibtn ibtn-ok" type="submit" value="保存" />
                                    <input id="pro_id" name="pro_id" type="hidden" value="{{$product.pro_id}}" />
                                    <input id="col_key" name="col_key" type="hidden" value="{{$product.col_key}}" />
                                    <input id="lang" name="lang" type="hidden" value="{{$product.lang}}" />
                                </p>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>

        <div class="clear"><!-- Clear Float --></div>

    </div>

</div>
<script type="text/javascript">
$('#brand_id').change(function(){
	getintro($(this).val());
});
{{if !$product.pro_id}}
getintro($('#brand_id').val());
{{/if}}
function getintro(id){
	var url="{{url controller='Products' action='getbrandintro'}}/id/"+id+'?tid='+new Date().getTime();
	$.getJSON(url,function(d){
	//console.log(d);
	for(var i=1;i<5;i++){
		if(d[i]){
			$(document.editform["params[intro]["+i+"][title]"]).val(d[i]['title']);
			$(document.editform["params[intro]["+i+"][content]"]).val(d[i]['content']);
		}
	}
	})
	
}
function removeSize(){
	var st=document.getElementById('sizeTable');
	if(st.rows.length<3)return;
	var l=st.rows[st.rows.length-1];
	st.tBodies[0].removeChild(l);
	sizeCount--;
	
}
function addSize(){
	var c=sizeCount;
	
	var st=document.getElementById('sizeTable');
	var tr=document.createElement('tr');
	var td1=document.createElement('td');
	var td2=document.createElement('td');
	td1.appendChild(createInput('text','params[size]['+c+'][title]','fluid-input'));
	td2.appendChild(createInput('text','params[size]['+c+'][content]','fluid-input'));
	tr.appendChild(td1);
	tr.appendChild(td2);
	st.tBodies[0].appendChild(tr);
	sizeCount=c+1;
}
function removeMemo(){
	var st=document.getElementById('memoTable');
	if(st.rows.length<3)return;
	var l=st.rows[st.rows.length-1];
	st.tBodies[0].removeChild(l);
	memoCount--;
	
}
function addMemo(){
	var c=memoCount;
	
	var st=document.getElementById('memoTable');
	var tr=document.createElement('tr');
	var td1=document.createElement('td');
	var td2=document.createElement('td');
	td1.appendChild(createInput('text','params[memo]['+c+'][title]','fluid-input'));
	td2.appendChild(createInput('text','params[memo]['+c+'][content]','fluid-input'));
	tr.appendChild(td1);
	tr.appendChild(td2);
	st.tBodies[0].appendChild(tr);
	memoCount=c+1;
}
function createInput(tp,nm,cls){
	var ip=document.createElement('input');
	ip.type=tp;
	ip.name=nm;
	ip.className=cls;
	var w=document.createElement('b');
	w.className='fluid-input';
	var r=document.createElement('b');
	r.className='fluid-input-inner';
	r.appendChild(ip);
	w.appendChild(r);
	return w;
}
</script>
</body>

</html>

