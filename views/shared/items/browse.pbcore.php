<?php echo '<?xml version="1.0" encoding="UTF-8"?>
<pbcoreCollection xsi:schemaLocation="http://www.PBCore.org/PBCore/PBCoreNamespace.html http://pbcore.org/xsd/pbcore-2.0.xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.pbcore.org/PBCore/PBCoreNamespace.html">
'; ?>

<?php while(loop_items()): ?>

<?php $item = get_current_item(); ?>
<pbcoreDescriptionDocument>
<?php foreach (item('PBCore', 'Date Broadcast', array('all'=>true)) as $datebroadcast) { ?>
	<pbcoreAssetDate dateType="Broadcast"><?php echo html_escape($datebroadcast); ?></pbcoreAssetDate>
<?php } ?>
<?php foreach (item('PBCore', 'Date Created', array('all'=>true)) as $datecreated) { ?>
	<pbcoreAssetDate dateType="Created"><?php echo html_escape($datecreated); ?></pbcoreAssetDate>
<?php } ?>
<pbcoreIdentifier source="<?php echo "Omeka:" ; echo  html_escape(get_option('site_title')); ?>"><?php echo item('permalink'); ?></pbcoreIdentifier>
<?php foreach (item('PBCore', 'Title', array('all'=>true)) as $title) { ?>
	<pbcoreTitle><?php echo html_escape($title); ?></pbcoreTitle>
<?php } ?>
<?php foreach (item('PBCore', 'Episode Title', array('all'=>true)) as $episodetitle) { ?>
	<pbcoreTitle titleType="Episode"><?php echo html_escape($episodetitle); ?></pbcoreTitle>
<?php } ?>
<?php foreach (item('PBCore', 'Series Title', array('all'=>true)) as $seriestitle) { ?>
	<pbcoreTitle titleType="Series"><?php echo html_escape($seriestitle); ?></pbcoreTitle>
<?php } ?>
<?php if (empty($title) && empty($episodetitle) && empty($seriestitle)) { ?>
	<pbcoreTitle>No Title Available</pbcoreTitle>
<?php } ?>
<?php foreach ($item->Tags as $tag) { ?>
	<pbcoreSubject source="Free tags"><?php echo html_escape($tag); ?></pbcoreSubject>
<?php } ?>
<?php foreach (item('PBCore', 'Description', array('all'=>true)) as $description) { ?>
	<pbcoreDescription><?php echo html_escape($description); ?></pbcoreDescription>
<?php } ?>
<?php foreach (item('PBCore', 'Transcription', array('all'=>true)) as $transcription) { ?>
	<pbcoreDescription descriptionType="Transcript"><?php echo html_escape($transcription); ?></pbcoreDescription>
<?php } ?>
<?php if (empty($description) && empty($transcription)) { ?>
	<pbcoreDescription>No Description Available</pbcoreDescription>
<?php } ?>
    <pbcoreRelation>
        <pbcoreRelationType>Is Part Of</pbcoreRelationType>
        <pbcoreRelationIdentifier source="<?php echo "Omeka:" ; echo  html_escape(get_option('site_title')); ?>"><?php $Collection = get_collection_for_item(); echo $Collection->name; ?></pbcoreRelationIdentifier>
    </pbcoreRelation>
	<pbcoreCoverage>
		<coverage><?php if (function_exists('geolocation_get_location_for_item') && geolocation_get_location_for_item($item, true)) { $location = geolocation_get_location_for_item($item, true); echo html_escape($location->address); } ?></coverage>
		<coverageType>Spatial</coverageType>
	</pbcoreCoverage>
<?php foreach (item('PBCore', 'Creator', array('all'=>true)) as $creator) { ?>
	<pbcoreCreator>
		<creator><?php echo html_escape($creator); ?></creator>
		<creatorRole>Creator</creatorRole>
	</pbcoreCreator>
<?php } ?>
<?php foreach (item('PBCore', 'Interviewee', array('all'=>true)) as $interviewee) { ?>
	<pbcoreContributor>
		<contributor><?php echo html_escape($interviewee); ?></contributor>
		<contributorRole><?php echo "Interviewee"; ?></contributorRole>
	</pbcoreContributor>
<?php } ?>
<?php foreach (item('PBCore', 'Interviewer', array('all'=>true)) as $interviewer) { ?>
	<pbcoreContributor>
		<contributor><?php echo html_escape($interviewer); ?></contributor>
		<contributorRole><?php echo "Interviewer"; ?></contributorRole>
	</pbcoreContributor>
<?php } ?>
<?php foreach (item('PBCore', 'Host', array('all'=>true)) as $host) { ?>
	<pbcoreContributor>
		<contributor><?php echo html_escape($host); ?></contributor>
		<contributorRole><?php echo "Host"; ?></contributorRole>
	</pbcoreContributor>
<?php } ?>
<?php foreach (item('PBCore', 'Rights', array('all'=>true)) as $rights) { ?>
	<pbcoreRightsSummary>
		<rightsSummary><?php echo html_escape($rights); ?></rightsSummary>
	</pbcoreRightsSummary>
<?php } ?>	
	<pbcoreInstantiation>	
		<instantiationIdentifier source="<?php echo "Omeka:" ; echo  html_escape(get_option('site_title')); ?>"><?php echo item('permalink'); ?></instantiationIdentifier>
		<instantiationIdentifier source="<?php echo "Omeka:" ; echo  html_escape(get_option('site_title')); echo ".item_id"?>"><?php echo $item->id; ?></instantiationIdentifier>	
		<instantiationLocation source="<?php echo "Omeka:" ; echo  html_escape(get_option('site_title')); ?>"><?php echo item('permalink'); ?></instantiationLocation>
		<?php foreach ($item->Files as $file) { ?>
		<instantiationDigital><?php echo $file->mime_browser; ?></instantiationDigital>
		 <?php } ?>
		<instantiationDuration><?php echo item('PBCore', 'Duration'); ?></instantiationDuration>
		<?php foreach ($item->Files as $file) { ?>
        <instantiationPart>
              <instantiationIdentifier><?php echo html_escape($file->getWebPath('archive')); ?></instantiationIdentifier>
            <instantiationIdentifier source="<?php echo "Omeka:" ; echo  html_escape(get_option('site_title')); echo ".original_filename"?>"><?php echo $file->original_filename; ?></instantiationIdentifier>
            <instantiationIdentifier source="<?php echo "Omeka:" ; echo  html_escape(get_option('site_title')); echo ".archive_filename"?>"><?php echo $file->archive_filename; ?></instantiationIdentifier>
            <instantiationLocation source="<?php echo "Omeka:" ; echo  html_escape(get_option('site_title')); ?>"><?php echo item('permalink'); ?></instantiationLocation>
              <instantiationDate dateType="Date Modified"><?php echo $file->modified; ?></instantiationDate>
            <instantiationFileSize unitsOfMeasure="bytes"><?php echo $file->size; ?></instantiationFileSize>
            <instantiationAnnotation annotationType="md5"><?php echo $file->authentication; ?></instantiationAnnotation>
        </instantiationPart>
        <?php } ?>
	</pbcoreInstantiation>
<?php foreach (item('PBCore', 'Physical Location', array('all'=>true)) as $physical_location) { ?>	
	<pbcoreInstantiation>
		<instantiationIdentifier source="<?php echo "Omeka:" ; echo  html_escape(get_option('site_title')); ?>"><?php echo item('permalink'); ?></instantiationIdentifier>
		<instantiationPhysical><?php echo item('PBCore', 'Physical Format'); ?></instantiationPhysical>
		<instantiationLocation><?php echo html_escape($physical_location); ?></instantiationLocation>
	</pbcoreInstantiation> 
	<?php } ?>
	</pbcoreDescriptionDocument>
<?php endwhile; ?>
</pbcoreCollection>