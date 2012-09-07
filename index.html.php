<%@ Page Title="Introduction" Inherits="index" %>
<!DOCTYPE HTML>
<html>
	<body>
		<php:Form runat="server">
			<php:Label ID="UserInfoLabel" Text="Here the text will be displayed" runat="server" />
			<php:TextBox ID="TextBox1" runat="server" Text="This is a Text box" />
			<php:Button runat="server" ID="Button1" Text="This is a Text box" OnClicked="Button1_Clicked" />
    	</php:Form>
    </body>
</html>
