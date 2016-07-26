function SortSelect(formName,sortPan,searchName,jumpNum){

	//对象属性
	this.FormObj	= document.getElementsByName(formName)[0];
	this.sortPan	= document.getElementsByName(sortPan)[0];
	this.searchObj  = document.getElementsByName(searchName)[0];
	this.jumpNum	= document.getElementsByName(jumpNum)[0];

	//+--------------------------------------------------------
	//| 方法：列表搜索
	//+--------------------------------------------------------

	this.Search	= function(){
		var length = this.sortPan.options.length;
		for (i =0 ;i<length; i++){
			if (this.sortPan.options[ i ].text.indexOf(this.searchObj.value)!=-1)
			{
				this.sortPan.item(i).selected = true;
				break;
			}
		}
	}
	//+--------------------------------------------------------
	//| 方法：跳转
	//+--------------------------------------------------------
	this.jump = function (){
		var n= this.jumpNum.value;
		var iIndex = this.sortPan.selectedIndex;	
		var i= n-1;
		if( i == iIndex) return;
		if (i<iIndex)	
			{
			for (k=0;k<iIndex-i;k++)	this.sortUp();
			}
		else 
			{
			for (k=0;k<i-iIndex;k++)	this.sortDown();
			}
	}
	//+--------------------------------------------------------
	//| 方法：上移一位
	//+--------------------------------------------------------
	this.sortUp = function ()
	{
		try
		{
			var iIndex = this.sortPan.selectedIndex;	
			
			if(iIndex == 0)
			{
				return;
			}
			var curName = this.sortPan.item(iIndex).text;
			var ilength,iplace
			ilength=curName.length;
			iplace=curName.indexOf(".");
			var strNameState,strNameSpace
			strNameState=curName.substr(iplace+1,ilength)
			strNameSpace=curName.substr(0,iplace+1)
			var strNameStateMiddle
			strNameStateMiddle=strNameState
			
			var curName1 = this.sortPan.item(iIndex-1).text;
			var ilength1,iplace1
			ilength1=curName1.length;
			iplace1=curName1.indexOf(".");
			var strNameState1,strNameSpace1
			strNameState1=curName1.substr(iplace1+1,ilength1)
			strNameSpace1=curName1.substr(0,iplace1+1)
			strNameState=strNameState1
			strNameState1=strNameStateMiddle
			this.sortPan.item(iIndex).text =strNameSpace+strNameState
			 this.sortPan.item(parseInt(iIndex) - 1).text=strNameSpace1+strNameState1
	
			var curValue = this.sortPan.item(iIndex).value;
			this.sortPan.item(iIndex).value = this.sortPan.item(parseInt(iIndex) - 1).value;
			this.sortPan.item(parseInt(iIndex)-1).value = curValue;
		
			this.sortPan.item(parseInt(iIndex)-1).selected = true;
		}
		catch(e)
		{
			return;
		}
	}

	//+--------------------------------------------------------
	//| 方法：移动到第一位
	//+--------------------------------------------------------
	this.fnFirst = function ()
	{
		try
		{
			var iIndex = this.sortPan.selectedIndex;
			 
			if(iIndex == 0)
			{
				return;
			}
			
			while (iIndex>0)
			{	
				var curName = this.sortPan.item(iIndex).text;
				
				var ilength,iplace
			ilength=curName.length;
			iplace=curName.indexOf(".");
			var strNameState,strNameSpace
			strNameState=curName.substr(iplace+1,ilength)
			strNameSpace=curName.substr(0,iplace+1)
			var strNameStateMiddle
			strNameStateMiddle=strNameState
			
			var curName1 = this.sortPan.item(iIndex-1).text;
			var ilength1,iplace1
			ilength1=curName1.length;
			iplace1=curName1.indexOf(".");
			var strNameState1,strNameSpace1
			strNameState1=curName1.substr(iplace1+1,ilength1)
			strNameSpace1=curName1.substr(0,iplace1+1)
			strNameState=strNameState1
			strNameState1=strNameStateMiddle
			this.sortPan.item(iIndex).text =strNameSpace+strNameState
			 this.sortPan.item(parseInt(iIndex) - 1).text=strNameSpace1+strNameState1
				var curValue = this.sortPan.item(iIndex).value;

				this.sortPan.item(iIndex).value = this.sortPan.item(parseInt(iIndex) - 1).value;
				this.sortPan.item(parseInt(iIndex)-1).value = curValue;	
				this.sortPan.item(parseInt(iIndex)-1).selected = true;	
				iIndex=iIndex-1
			
			}
		}
		catch(e)
		{
			return;
		}
	}
	//+--------------------------------------------------------
	//| 方法：下移一位
	//+--------------------------------------------------------
	this.sortDown = function ()
	{
		try
		{
			var iIndex = this.sortPan.selectedIndex;	
			if(iIndex == this.sortPan.length - 1)
			{
				return;
			}
			var curName = this.sortPan.item(iIndex).text;
			var ilength,iplace
			ilength=curName.length;
			iplace=curName.indexOf(".");
			var strNameState,strNameSpace
			strNameState=curName.substr(iplace+1,ilength)
			strNameSpace=curName.substr(0,iplace+1)
			var strNameStateMiddle
			strNameStateMiddle=strNameState
			
			var curName1 = this.sortPan.item(iIndex+1).text;
			var ilength1,iplace1
			ilength1=curName1.length;
			iplace1=curName1.indexOf(".");
			var strNameState1,strNameSpace1
			strNameState1=curName1.substr(iplace1+1,ilength1)
			strNameSpace1=curName1.substr(0,iplace1+1)
			strNameState=strNameState1
			strNameState1=strNameStateMiddle
			this.sortPan.item(iIndex).text =strNameSpace+strNameState
			 this.sortPan.item(parseInt(iIndex) + 1).text=strNameSpace1+strNameState1

			var curValue = this.sortPan.item(iIndex).value;
			this.sortPan.item(iIndex).value = this.sortPan.item(parseInt(iIndex) + 1).value;
			this.sortPan.item(parseInt(iIndex)+1).value = curValue;
		
			this.sortPan.item(parseInt(iIndex) + 1).selected = true;
		}
		catch(e)	
		{
			return;
		}
		
	}
	//+--------------------------------------------------------
	//| 方法：移动到最后
	//+--------------------------------------------------------
	this.fnEnd = function ()
	{
		try
		{
			var iIndex = this.sortPan.selectedIndex;	
			if(iIndex == this.sortPan.length - 1)
			{
				return;
			}
			while (iIndex<(this.sortPan.length - 1))
			{
				var curName = this.sortPan.item(iIndex).text;
				var ilength,iplace
			ilength=curName.length;
			iplace=curName.indexOf(".");
			var strNameState,strNameSpace
			strNameState=curName.substr(iplace+1,ilength)
			strNameSpace=curName.substr(0,iplace+1)
			var strNameStateMiddle
			strNameStateMiddle=strNameState
			
			var curName1 = this.sortPan.item(iIndex+1).text;
			var ilength1,iplace1
			ilength1=curName1.length;
			iplace1=curName1.indexOf(".");
			var strNameState1,strNameSpace1
			strNameState1=curName1.substr(iplace1+1,ilength1)
			strNameSpace1=curName1.substr(0,iplace1+1)
			strNameState=strNameState1
			strNameState1=strNameStateMiddle
			this.sortPan.item(iIndex).text =strNameSpace+strNameState
			 this.sortPan.item(parseInt(iIndex) + 1).text=strNameSpace1+strNameState1
		
				var curValue = this.sortPan.item(iIndex).value;
				this.sortPan.item(iIndex).value = this.sortPan.item(parseInt(iIndex) + 1).value;
				this.sortPan.item(parseInt(iIndex)+1).value = curValue;
		
				this.sortPan.item(parseInt(iIndex) + 1).selected = true;
				iIndex=iIndex+1
			}
		}
		catch(e)	
		{
			return;
		}

	}
	//+--------------------------------------------------------
	//| 方法：排序保存
	//+--------------------------------------------------------
	this.ok = function ()
	{
		var str='';
		var iplace;
		for (i = 0; i <= this.sortPan.options.length-1; i++) { 
			iplace = this.sortPan.options[ i ].text.indexOf(".");
			str += this.sortPan.options[ i ].value + ":" + this.sortPan.options[ i ].text.substr(0,iplace) + ",";
		}
		this.FormObj.seqNoList.value = str.substr(0,str.length-1);
		//alert(this.FormObj.seqNoList.value);
	}

	//+--------------------------------------------------------
	//| 结束
	//+--------------------------------------------------------

}