<?php
add_plugin_hook('install', 'install');
add_plugin_hook('uninstall', 'uninstall');
add_filter('define_response_contexts', 'pbcoreOutputReponseContext');
add_filter('define_action_contexts', 'pbcoreOutputActionContext');
add_plugin_hook('public_theme_header', 'pbcoreThemeHeader');

function install() {
	$elementSetMetadata = array(
	    'name'        => "PBCore", 
	    'description' => "PBCore is a metadata standard for audiovisual media developed by the public broadcasting community. See http://www.pbcore.org/documentation/",
	);
	$elements = array(

	//Maps to Date Created (assetDate type:created).
		array(
			'label' => 'Date Created', 
			'name'  => 'Date Created',
			'description' => 'The original date that the media item was created. In the case of raw interviews, the date on which the interview was conducted. Format: YYYY-MM-DD',
			'data_type'   => 'Tiny Text',
		),

	//Maps to Date Broadcast (assetDate type:broadcast).
		array(
			'label' => 'Date Broadcast', 
			'name'  => 'Date Broadcast',
			'description' => 'The date on which the audio was originally broadcast. Format: YYYY-MM-DD',
			'data_type'   => 'Tiny Text',
		),

	//AUTOFILL: URI for the Omeka landing page for the item. Identifier source is always Omeka.
	    array(
			'label' => 'Identifier', 
			'name'  => 'Identifier',
			'description' => 'Best practice is to identify the media item (whether analog or digital) by means of an unambiguous string or number corresponding to an established or formal identification system if one exists. We recommend using the item\'s Omeka URL. (e.g., http://myomeka.com/items/show/1) If you are using the Internet Archive Plugin, this field will be autofilled.',
			'data_type'   => 'Tiny Text',
	    ),

	//Item title
	    array(
			'label' => 'Title', 
	        'name'  => 'Title',
			'description' => 'The name given to the media item you are cataloging. It is the unique name everyone should use to refer to or search for a particular media item. There are situations in which no proper or given title is available, e.g., photographs or segments harvested from a longer work or program. In these situations a "supplied title" must be invented and used to name the media item. Be considerate of and sensitive to the end user who is attempting to search for your media item.',
			'data_type'	=> 'Tiny Text',
	    ),

		array(
	   		'label' => 'Episode Title', 
	   		'name'  => 'Episode Title',
	   		'description' => 'If applicable, the episode or piece to which a media item contributed.',
	   		'data_type'   => 'Tiny Text',
	   		'_refines'    => 'Title',
	       ), 

		array(
	  		'label' => 'Series Title', 
	  		'name'  => 'Series Title',
	  		'description' =>'If applicable, the larger series to which the episode or piece contributed.',
	  		'data_type'   => 'Tiny Text',
	         '_refines'    => 'Title',
	        ),

	//We should have this field in our mapping doc.    
	    array(
			'label' => 'Description', 
			'name'  => 'Description',
			'description' => 'Uses free-form text to report abstracts, or summaries about the intellectual content of a media item you are cataloging. The information may be in the form of a paragraph giving an individual program description or brief content reviews.',
	     ),

	//AUTOFILL: but make editable. 	
		array(
			'label' => 'Creator', 
			'name'  => 'Creator',
			'description'	=> 'Identifies a person or organization primarily responsible for creating a media item. The creator may be considered an author and could be one or more people, a business, organization, group, project or service. (For personal names use "LastName, FirstName MiddleName, Suffix").',
			'data_type'   => 'Tiny Text',
		),

	//We should have this field in our mapping doc.    
	    array(
			'label' => 'Interviewee', 
			'name'  => 'Interviewee',
			'description' => 'The person(s) being interviewed. (For personal names use "LastName, FirstName MiddleName, Suffix").',
			'data_type'   => 'Tiny Text',
	     ),
	
	//We should have this field in our mapping doc.    
	    array(
			'label' => 'Interviewer', 
			'name'  => 'Interviewer',
			'description'	=> 'The person(s) conducting the interview. (For personal names use "LastName, FirstName MiddleName, Suffix").',
			'data_type'   => 'Tiny Text',
		     ),

	//We should have this field in our mapping doc.    
	    array(
			'label' => 'Host', 
			'name'  => 'Host',
			'description' => 'If applicable, the person hosting the broadcast piece. (For personal names use "LastName, FirstName MiddleName, Suffix").',
			'data_type'   => 'Tiny Text',
	     ),

		array(
			'label' => 'Rights', 
			'name'  => 'Rights',
			'description'	=> 'Information about rights to the media item. Typically, rights information includes a statement about various property rights associated with the resource, including intellectual property rights.',
		),

	//Physical format comes with a picklist
		array(
			'label'  => 'Physical Format', 
			'name'  => 'Physical Format', 
			'description' => 'The format of a particular version or rendition of a media item as it exists in an actual physical form that occupies physical space (e.g., a tape on a shelf), rather than as a digital file residing on a server or hard drive.', 
			'data_type'   => 'Tiny Text',
		),

	//Display digital format also comes with a picklist. Mimetype of original uploaded file. Should be the mimetype of whatever the instantiation is. Potentially prepopulate. 
		array(
			'label' => 'Digital Format', 
			'name'  => 'Digital Format',
			'data_type'   => 'Tiny Text',
		),

	//This is not hardcoded.
		array(
			'label' => 'Physical Location', 
			'name'  => 'Physical Location',
			'description' => 'An address for a physical media item. For an organization or producer acting as caretaker of a media resource, this field may contain information about a specific shelf location for an item, including an organization\'s name, departmental name, shelf ID and contact information.',
			'data_type'   => 'Tiny Text',
		 ),

	//AUTOFILL: Internet Archive landing page for the item. Maps to instantiationLocation in PBCore XML.
		array(
			'label' => 'Digital Location', 
			'name'  => 'Digital Location',
			'description' => 'An address for a digital media item. Employs an unambiguous reference or identifier for a digital rendition/instantiation of a media item and may include domain, path, filename or html page. This includes URIs for each digital file format created by the Internet Archive (will have multiple values).',
			'data_type'   => 'Tiny Text',
		  ),

	//AUTOFILL: Can we automatically detect duration of files when they are uploaded?
		array(
			'label' => 'Duration', 
			'name'  => 'Duration',
			'description'	=> 'Provides a timestamp for the overall length or duration of the audio. Represents the playback time. Format: HH:MM:SS',
			'data_type'   => 'Tiny Text',
		),

		array(
			'label'       => 'Music/Sound Used', 
			'name'        => 'Music/Sound Used', 
			'description' => 'Details on music or other sound clips that contributed to the piece. May include title, artist, album, timestamp, producer and record label information.',
		),

		array(
	   		'label' => 'Date Peg', 
	   		'name'  => 'Date Peg',
	   		'description' => 'A holiday or other date relevant to the item (e.g., Christmas, Yom Kippur, Independence Day).',
	   		'data_type'   => 'Tiny Text',
	       ),

		array(
			'label'       => 'Notes', 
			'name'        => 'Notes', 
			'description' => 'Any other notes or information about the media item, including bibliography/research information, contact information, and legacy metadata.',
			'data_type'   => 'Text',
		),

		array(
			'label' => 'Transcription', 
			'name'  => 'Transcription',
			'description' => 'The textual transcription of the media item.',
			'data_type'   => 'Text',
		  ),
	);
	insert_element_set($elementSetMetadata, $elements);
}

function uninstall()
{
	
}

add_filter('admin_items_form_tabs', 'pbcore_items_form_tabs');

function pbcore_items_form_tabs($tabs, $item)
{
	unset($tabs['Dublin Core']);
	unset($tabs['Item Type Metadata']);
	return $tabs;
}

function pbcoreOutputReponseContext($context)
{
    $context['pbcore'] = array('suffix'  => 'pbcore', 
                            'headers' => array('Content-Type' => 'text/xml'));

    return $context;
}

function pbcoreOutputActionContext($context, $controller)
{
    if ($controller instanceof ItemsController) {
        $context['show'][] = 'pbcore';
        $context['browse'][] = 'pbcore';
    }

    return $context;
}

function pbcoreThemeHeader()
{
	echo pbcoreOutput();
}
   
function pbcoreOutput()
{
    $request = Zend_Controller_Front::getInstance()->getRequest();

	if ($request->getControllerName() == 'items' && $request->getActionName() == 'show') {
	    return '<link rel="alternate" type="application/rss+xml" href="'.item_uri().'?output=pbcore" id="pbcore"/>' . "\n";
	}
	
	if ($request->getControllerName() == 'items' && $request->getActionName() == 'browse') {
            echo '<link rel="alternate" type="application/rss+xml" href="' . item_uri() . '?output=pbcore" id="pbcore"/>' . "\n";
        }

}

  