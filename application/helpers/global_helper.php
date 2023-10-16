<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('memberName'))
{
    function memberName($id){
        $ci=& get_instance();
    	$ci->load->database(); 
	    $sql = "select firstName,lastName from users where userID=$id "; 
	    $query = $ci->db->query($sql);
	    $row = $query->row();
	    $name= $row->firstName.' '.$row->lastName;
	    return $name;
    }   
}

if ( ! function_exists('getProjectByID'))
{
    function getProjectByID($id){
        $ci=& get_instance();
    	$ci->load->database(); 
	    $sql = "select projectName from projects where projectID=$id "; 
	    $query = $ci->db->query($sql);
	    $row = $query->row();
	    return $row->projectName;
    }   
}

if ( ! function_exists('getProfilePicture'))
{
    function getProfilePicture($userid){
        $ci=& get_instance();
    	$ci->load->database(); 
	    $sql = "select image,gender from users where userID=$userid "; 
	    $query = $ci->db->query($sql);
	    $row = $query->row();
	    if($row->image !=''){
	    	return $row->image;
	    }else if($row->gender == 'Male'){
	    	return 'staff-male.jpg';
	    }else if($row->gender == 'Female'){
	    	return 'staff-female.jpg';
	    }
	    
    }   
}

if ( ! function_exists('propertyTypeName'))
{
    function propertyTypeName($typeID){
        $ci=& get_instance();
    	$ci->load->database(); 
	    $sql = "select typeName from propertytype where typeID=$typeID "; 
	    $query = $ci->db->query($sql);
	    $row = $query->row();
	    if($row->typeName !=''){
	    	return $row->typeName;
	    }else{
	    	return 'Unnamed Type';
	    }
	    
    }   
}

if ( ! function_exists('propertyTypeSize'))
{
    function propertyTypeSize($typeID){
        $ci=& get_instance();
    	$ci->load->database(); 
	    $sql = "select typeSize,dimensionWidth,dimensionHeight from propertytype where typeID=$typeID "; 
	    $query = $ci->db->query($sql);
	    $row = $query->row();
	    if($row->typeSize !=''){
	    	return $row->typeSize.'('.$row->dimensionWidth.'" x '.$row->dimensionHeight.'")';
	    }else{
	    	return 'Unnamed Size';
	    }
	    
    }   
}

if ( ! function_exists('typeSizeByProjectID'))
{
    function typeSizeByProjectID($projectID){
        $ci=& get_instance();
    	$ci->load->database(); 
	    $sql = "select typeName,typeSize,dimensionWidth,dimensionHeight from propertytype  where projectID=$projectID "; 
	    $query = $ci->db->query($sql);
	    $result = $query->result();
	    return $result;
    }   
}

if ( ! function_exists('typeSizeByResidential'))
{
    function typeSizeByResidential($projectID){
        $ci=& get_instance();
    	$ci->load->database(); 
	    $sql = "select typeSize,dimensionWidth,dimensionHeight from propertytype  where projectID=$projectID AND typeName='Residential'"; 
	    $query = $ci->db->query($sql);
	    $result = $query->result();
	    return $result;
    }   
}

if ( ! function_exists('typeSizeByCommercial'))
{
    function typeSizeByCommercial($projectID){
        $ci=& get_instance();
    	$ci->load->database(); 
	    $sql = "select typeSize,dimensionWidth,dimensionHeight from propertytype  where projectID=$projectID AND typeName='Commercial'"; 
	    $query = $ci->db->query($sql);
	    $result = $query->result();
	    return $result;
    }   
}

if ( ! function_exists('countNewBooking'))
{
    function countNewBooking(){
        $ci=& get_instance();
    	$ci->load->database(); 
	    $sql = "select bookingID from onlinebooking where readStatus='no' "; 
	    $query = $ci->db->query($sql);
	    $rec = $query->result();
	     return count($rec);
	    
    }   
}

if ( ! function_exists('bookingNotification'))
{
    function bookingNotification(){
        $ci=& get_instance();
    	$ci->load->database(); 
    	$ci->db->select('bookingID,applicantPicture,applicantName,projectID,typeID, readStatus');
    	$ci->db->from('onlinebooking');
    	$ci->db->where('readStatus','no');
    	$ci->db->limit(5);
    	$ci->db->order_by('bookingID','desc');
    	$rec=$ci->db->get();
	    $record = $rec->result();
	    return $record;
	    
    }   
}

if ( ! function_exists('callBackNotification'))
{
    function callBackNotification(){
        $ci=& get_instance();
    	$ci->load->database(); 
    	$ci->db->select('n.leadID,n.callBackDate,n.addDate,n.status, l.name,l.ccode, l.contact,l.purpose');
    	$ci->db->where('n.userID',$ci->session->userdata('userID'));
    	$ci->db->from('notifications as n');
    	$ci->db->join('leads as l', 'n.leadID = l.leadID');
    	$ci->db->limit(5);
    	$rec=$ci->db->get();
	    $record = $rec->result();
	    return $record;
	    
    }   
}


if ( ! function_exists('totalLeadsPerUser'))
{
    function totalLeadsPerUser($userID){
        $ci=& get_instance();
    	$ci->load->database(); 
    	$ci->db->select('COUNT(leadID) as totalLeads');
    	$ci->db->where('userID',$userID);
    	$ci->db->from('leads');
    	$rec=$ci->db->get();
	    $record = $rec->result();
	    return $record[0]->totalLeads;
	    
    }   
}

if ( ! function_exists('totalBookingPerUser'))
{
    function totalBookingPerUser($userID){
        $ci=& get_instance();
    	$ci->load->database(); 
    	$ci->db->select('COUNT(leadID) as totalLeads');
    	$ci->db->where('userID',$userID);
    	$ci->db->where('purpose','Booking');
    	$ci->db->from('leads');
    	$rec=$ci->db->get();
	    $record = $rec->result();
	    return $record[0]->totalLeads;
	    
    }   
}

if ( ! function_exists('countMultiBooking'))
{
    function countMultiBooking($leadID){
        $ci=& get_instance();
        $ci->load->database(); 
        $ci->db->select('leadID');
        $ci->db->where('multiBookingLead',$leadID);
        $ci->db->from('leads');
        $rec=$ci->db->get();
        $record = $rec->result();
        return count($record);
        /*$num = $rec->num_rows();
        if ($num > 0) {
            
        }else{
            return '';
        }*/
        
        
    }   
}