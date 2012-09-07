<%@ Page Inherits="update_panel" %>
<!DOCTYPE HTML>
<html>
	<body>
		<php:Form runat="server">
			<!-- 
				Script Manager is necessary to add when using Update Panels or Builtin Ajax Library
			 -->
			<php:ScriptManager runat="server" />
			
			<php:Label runat="server" ID="Label1" />
			<br /><br />
			
			<!-- 
				1st UpdatePanel:
			 -->
			<php:UpdatePanel runat="server" ID="UpdatePanel1">
				<php:Label runat="server" ID="Label2" />
				<br />
				<php:Button runat="server" OnClicked="Button1_Clicked" Text="Hey I will only update this Update Panel" />
			</php:UpdatePanel>
			<br /><br />
			
			<!-- 
				2nd UpdatePanel:
			 -->
			<php:UpdatePanel runat="server">
				<php:Label runat="server" ID="Label3" />
				<br />
				<php:Button runat="server" OnClicked="Button2_Clicked" Text="I will update both Update Panels" />
			</php:UpdatePanel>
		</php:Form>
	</body>
</html>
