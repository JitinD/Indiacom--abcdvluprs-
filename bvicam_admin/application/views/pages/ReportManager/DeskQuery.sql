SELECT distinct(submission_member_id) 
FROM `attendance_master` 
		join 
	submission_master 
		on attendance_master.submission_id = submission_master.submission_id
WHERE `is_present_on_desk` = 1 and date(`attendance_dor`) = '2015-03-12'