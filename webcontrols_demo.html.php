<%@ Page Inherits="webcontrols_demo" %>
<!DOCTYPE HTML>
<html>
	<head>
		<style type="text/css">
			.Clicked
			{
				background-color:cyan;
			}
		</style>
	</head>
	<body>
		<!-- 
			Form is Container for all Server Control there must be only one instance of form in one page.
			If You are using master page it is best to put Form control in Master Page.
			
			All Control Propertise are persist of Post back.
			Eg: If you can Css Class of control on button click. it will be changed on every post back.
		 -->
		<php:Form runat="server">
			<h3>Label Control</h3>
			<!-- 
				Label Control print out span tag.
				
				All of Its Propertise will be persist
			 -->
			 <php:Label runat="server" 
			 			ID="Label1"
			 			AccessKey="U"
			 			CssClass="Label-Class"
			 			BackColor="gray"
			 			ForeColor="white"
			 			BorderColor="yellow"
			 			BorderStyle="dashed"
			 			BorderWidth="5px"
			 			
			 			Text="Hey I'm a Label"
			 />
			 
			<h3>Button Control</h3>
			<!-- 
				Button Control is use to add Button to Page
				
				Following Attributes can be used in Button
				Text: Text of Button
				OnClicked: The Function reference in Page, Master Page or User Control class
			 -->
			 <php:Button OnClicked="Button1_Clicked" runat="server" Text="Click Me To Change My Color Forever!" />
			 <br />
			 
			 <h3>Panel Control</h3>
			<!-- 
				Panel is server control replacement of DIV.
			 -->
			<php:Panel runat="server" ID="Panel1" Style="border:solid 1px black; width:200px; height:100px;">
				<php:Button OnClicked="Panel_Button1_Clicked" runat="server" Text="Increase Height" />
			</php:Panel>
			<br/>
			
			<h3>TextBox Control</h3>
			<!-- 
				TextBox is control replacement of HTML input type=text
				
				Following Attribute can be used in TextBox control
					Text: Default Text of TextBox
					TextMode: SingleLine, MultiLine and Password
			 -->
			 <php:TextBox runat="server" ID="TextBox1" Text="WoW!" />
			 <php:Button runat="server" OnClicked="TextBox1_Button_Clicked" Text="Show Whats Written" />
			 <br />
			 <h3>CheckBox Control</h3>
			 <!-- 
			 	CheckBox is control replacement of HTML input=check & its label
			 	
			 	Following Attribute can be used in TextBox control
					Text: Text of Label associated with checkbox
					Layout: Before or After
					AutoPostBack: either true checkbox will post back on check change or false won't post on change
					OnCheckChanged: Event name to called when checkbox is changed
					Checked: true or false (Default value of checkbox)
			  -->
				<php:CheckBox runat="server" ID="CheckBox1" 
			  				Layout="Before" Text="Hey I'm already checked & label is before check"
			   				Checked="True" />
				<php:CheckBox runat="server" ID="CheckBox2"
			   					AutoPostBack="True"
			   					OnCheckChanged="CheckBox2_CheckChanged"
			   					Text="I'm Ofcourse not checked" />
				<br />
			   	
			   	
			<h3>Image Control</h3>
			<!-- 
				Image control replacement of HTML img
				
				Following Attribute can be used in TextBox control
					AltText: Image alt text Attribute
					ImageUrl: Url of image
					ImageAlign: left, center and right
			 -->
			 <php:Image runat="server" ImageUrl="~/Assets/Images/TestImage.png" />
			 <php:Image runat="server" ImageUrl="http://sdd.me.uk/images/Facebook.png" />
			 <br />
			 
			 <h3>LinkButton</h3>
			<!-- 
				LinkButton Control renders a tag but acts as input type submit
				
				Attributes:
					Text: text of button
					OnClicked: Event to execute when button clicked
			 -->
			 <php:LinkButton runat="server" OnClicked="LinkButton1_Clicked" Text="Link Button Demo" />
		
		
			<h3>DropDownList Control</h3>
			<!-- 
				DropDownList renders HTML SELECT Element
				
				Some of uses are as follow
			 -->
			 <php:DropDownList runat="server" ID="DropDownList1">
			 	<php:ListItem Text="One" Value="one" />
			 	<php:ListItem Text="Two" Value="two" Enabled="False" />
			 	<php:ListItem Text="Three" Value="three" />
			 </php:DropDownList><br />
			 <php:LinkButton runat="server" OnClicked="DropDownList1_Show2">
			 	Show Two
			 </php:LinkButton><br />
			 <php:LinkButton runat="server" OnClicked="DropDownList1_Translate">
			 	Translate DropDownList
			 </php:LinkButton>
			 <br />
		</php:Form>
	</body>
</html>
