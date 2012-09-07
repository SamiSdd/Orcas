//Orcas Ajax Controller
//Author: Abdul Sami Siddiqui

var System = {
	ScriptManagerID: null,
	UpdatePanels: [],
	RegisterUpdatePanel: function(UpdatePanelID)
	{
		this.UpdatePanels.push(UpdatePanelID);
		this.HookPostBack();
	},
	HookPostBack: function()
	{
		var Form = jQuery("form:first");
		if (Form.attr("HookPostBack") != "true")
		{
			Form.each(function() {
				this.DoPost = function(EventTarget, EventArgument)
				{
					var UpdatePanelContainer = null;
					
					for(UpdatePanelIndex in System.UpdatePanels)
					{
						if (EventTarget.indexOf(System.UpdatePanels[UpdatePanelIndex]) > -1)
						{
							UpdatePanelContainer = System.UpdatePanels[UpdatePanelIndex];
							break;
						}
					}
					
					if (UpdatePanelContainer)
					{
						jQuery("[name='__EVENTTARGET']").val(EventTarget);
						jQuery("[name='__EVENTARGUMENT']").val(EventArgument);
						
						var PostData = jQuery(this).serialize();
						PostData += "&" + System.ScriptManagerID + "=" + UpdatePanelContainer;
						
						var Action = jQuery(this).attr("action");

						jQuery.post(Action, PostData, function(data, textStatus, dataType)
						{
							System.ProcessPostBackData(data);
						});
						
						return false;
					}
					else
					{
						return true;
					}
				}
			});
			Form.attr("HookPostBack", "true");
		}
		
		jQuery("input[type=submit]").each(function() {
			if ($(this).attr("onclick") == null)
			{
				$(this).attr("onclick", "return this.form.DoPost('" + this.name + "', '')");
			}
		});
	},
	ProcessPostBackData: function(data)
	{
		for(HiddenFieldID in data.HiddenFields)
		{
			jQuery("[name='" + HiddenFieldID + "']").val(data.HiddenFields[HiddenFieldID]);
		}
		
		for(UpdatePanelID in data.UpdatePanels)
		{
			jQuery("#" + UpdatePanelID).html(data.UpdatePanels[UpdatePanelID]);
		}
		
		System.HookPostBack();
	}
};


