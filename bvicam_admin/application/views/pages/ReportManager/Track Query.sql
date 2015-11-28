/* Track, session, count of members*/

/*select track_id, session_id, count(distinct(submission_master.submission_member_id)) as 'Number of members'
from 
	attendance_master join submission_master 
		on attendance_master.submission_id = submission_master.submission_id 
    join paper_schedule_tracker 
    	on submission_master.submission_paper_id = paper_schedule_tracker.paper_id 
    join schedule_master 
    on paper_schedule_tracker.schedule_id = schedule_master.schedule_id
where is_present_in_hall = 1 and date(`attendance_dor`) = '2015-03-12'
group by track_id, session_id*/

/* Track, session, count of papers*/

select track_id, session_id, count(distinct(submission_master.submission_paper_id)) as 'Number of papers'
from 
	attendance_master join submission_master 
		on attendance_master.submission_id = submission_master.submission_id 
    join paper_schedule_tracker 
    	on submission_master.submission_paper_id = paper_schedule_tracker.paper_id 
    join schedule_master 
    on paper_schedule_tracker.schedule_id = schedule_master.schedule_id
where is_present_in_hall = 1 and date(`attendance_dor`) = '2015-03-12'
group by track_id, session_id