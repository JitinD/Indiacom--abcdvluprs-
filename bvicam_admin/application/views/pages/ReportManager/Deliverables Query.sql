/*For Kit

SELECT count(*) as 'Number of kits' 
FROM `deliverables_status` 
WHERE `status` = 1 and (`deliverables_id` = 1 or `deliverables_id` = 3) and DATE(`deliverables_status_dor`) = '2015-03-12'
*/

/*For Proceedings*/

SELECT count(*) as 'Number of proceedings' 
FROM `deliverables_status` 
WHERE `status` = 1 and (`deliverables_id` = 2 or `deliverables_id` = 3) and DATE(`deliverables_status_dor`) = '2015-03-12'
