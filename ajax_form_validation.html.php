<%@ Page Inherits="ajax_form_validation" %>
<!DOCTYPE HTML>
<html>
	<head>
		<style type="text/css">
            form > div > div:after {  clear: both; content: "."; display: block; height: 0; line-height: 0; visibility: hidden; }
            form > div > div > span { display: block; float: left; margin: 10px 0; width: 110px; }
            input[type="text"], textarea, input[type="password"] { width: 200px; margin-top: 5px; min-height: 22px; }
            .SucessLabel { color:green; margin:10px 0px; display:block; }
            .ErrorLabel { color:red; margin:10px 0px; display:block; }
            .Required { background-color:red; }
        </style>
	</head>
	<body>
		<php:Form runat="server">
			<!-- 
				Add ScriptManager as we going to use update panel
			 -->
			<php:ScriptManager runat="server" />
			
			<!-- 
				Wrap Form in UpdatePanel and thats it
			 -->
			<php:UpdatePanel runat="server">
				<h2>Registration Form</h2>
				<div>
					<span>First Name *</span>
					<php:TextBox runat="server" ID="FirstNameTextBox" runat="server"></php:TextBox>
				</div>
				<div>
					<span>Last Name</span>
					<php:TextBox runat="server" ID="LastNameTextBox" runat="server"></php:TextBox>
				</div>
				<div>
					<span>Password *</span>
					<php:TextBox runat="server" ID="PasswordTextBox" runat="server" TextMode="Password"></php:TextBox>
				</div>
				<div>
					<php:CheckBox runat="server" ID="AllowAddress" AutoPostBack="True" OnCheckChanged="AllowAddress_CheckChanged" Text="I have fix address" Checked="True" />
				</div>
				<php:Panel runat="server" ID="AddressPanel">
					<span>Address *</span>
					<php:TextBox runat="server" ID="AddressTextBox" runat="server" TextMode="MultiLine"></php:TextBox>
				</php:Panel>
				<php:Label ID="MessageLabel" runat="server" />
				<br />
				<php:Button runat="server" Text="Save" OnClicked="Save_Form_Clicked"/>
			</php:UpdatePanel>
		</php:Form>
	</body>
</html>
