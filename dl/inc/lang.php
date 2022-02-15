<?php 
$site_config['lang']['site_name'] = 'file.mgame.us';
$site_config['lang'] = array(
	'site_name' => 'file.mgame.us',
	'site_title' => array(
		'vi' => 	$site_config['lang']['site_name'].' - Dịch vụ lưu trữ và chia sẻ tập tin trực thuộc mGame.us',
		'en' => 	$site_config['lang']['site_name'].' - Services store files and watch video online free',
	),
	'site_description' => array(
		'vi' => $site_config['lang']['site_name'].' sử dụng hệ thống máy chủ cấu hình mạnh, áp dụng kỹ thuật điện toán đám mây để lưu trữ tập tin. Tập tin tải lên được lưu trữ miễn phí không giới hạn dung lượng, hỗ trợ xem video trực tuyến.',
		'en' => $site_config['lang']['site_name'].' uses a powerful server configuration system that uses cloud computing to store files. File uploads are hosted for free with unlimited storage, support for online video viewing.',
	),
	'site_keywords' => array(
		'vi' => 'upload, download, free download, chia sẻ dữ liệu, free upload, dữ liệu trực tuyến, Windows, PC, Mac, OS X, Linux, Android, iPhone, iPad, free storage, cloud Storage, collaboration, file Sharing, share Files',
	),
	'welcome' => array(
		'vi' => 'Welcome mGame.us',
		'en' => 'Welcome',
	), 
	'site_introduce' => array(
		'vi' => $site_config['lang']['site_name'].' sử dụng hệ thống máy chủ cấu hình mạnh, áp dụng kỹ thuật điện toán đám mây để lưu trữ tập tin. Tập tin tải lên được lưu trữ miễn phí không giới hạn dung lượng, hỗ trợ xem video trực tuyến. Tốc độ download file nhanh nhất, mạnh nhất. Ngoài ra còn hỗ trợ link tải trực tiếp hoàn toàn miễn phí.',
		'en' => $site_config['lang']['site_name'].' Use a strong server configuration system, apply cloud computing techniques to file storage. File uploads are hosted for free with unlimited storage, support for online video viewing. Fastest, fastest file download speed. There is also free direct download link support.',
	),
	'unlimited_storage_title' => array(
		'vi' => 'About us:',
		'en' => 'Unlimited Storage',
	),
	'unlimited_storage_text' => array(
		'vi' => 'Website: http://mGame.us',
		'en' => 'Expanding capacity on demand.',
	),
	'max_file_upload' => array(
		'vi' => 'Diễn đàn: https://forum.mGame.us',
		'en' => 'Maximum file size 15Gb upload',
	),
	'unlimited_bandwidth_title' => array(
		'vi' => 'Liên hệ:',
		'en' => 'Unlimited Bandwidth',
	),
	'unlimited_bandwidth_text' => array(
		'vi' => 'Email: admin@mGame.us',
		'en' => 'Free for download and watching',
	),
	'unlimited_bandwidth_subtitle' => array(
		'vi' => 'Fanpage: https://www.facebook.com/mgame.us',
		'en' => 'Upload - Download - Watch Online',
	),
	'pay_per_view_title' => array(
		'vi' => 'Góp ý',
	),
	'pay_per_view_text' => array(
		'vi' => 'Mọi ý kiến góp ý. Vui lòng gửi liên hệ với chúng tôi qua email',
		'en' => 'Make money form views of video.',
	),
	'pay_per_view_subtitle' => array(
		'vi' => 'admin@mgame.us',
		'en' => 'Flexible payment.',
	),
	'tip_process_video' => array(
		'vi' => 'Thời gian xử lý video sang chế độ xem online tùy thuộc vào định dạng, kích cỡ video tải lên. Từ vài phút cho đến vài giờ.',
		'en' => 'Processing time depends on the format of your original video, file size, and upload traffic. Depending on these factors, video processing could take a few minutes or several hours.',
	),
	'tip_process_video_statu' => array(
		'vi' => 'Trạng thái xử lý video sẽ được cập nhập qua phần <a href="'.$site_config['homepage'].'/dashboard/manager" target="_blank">File Manager</a>.',
		'en' => 'Video processing status will be updated at <a href="'.$site_config['homepage'].'/dashboard/manager" target="_blank">File Manager</a>.',
	),
	'total_file_upload' => array(
		'vi' => 'Tổng tệp tin',
		'en' => 'Total number files',
	),
	'total_file_size' => array(
		'vi' => 'Tổng dung lượng',
		'en' => 'Total size',
	),
	'balance' => array(
		'vi' => 'Số dư',
		'en' => 'Balance',
	),
	'success' => array(
		'vi' => 'Thành công',
		'en' => 'Success',
	),
	'error' => array(
		'vi' => 'Lỗi',
		'en' => 'Error',
	),
	'contact' => array(
		'vi' => 'Liên hệ',
		'en' => 'Contact',
	),
	'processing_wait' => array(
		'vi' => 'Đang xử lý, vui lòng chờ...',
		'en' => 'Processing, please wait...',
	),

	// Dashboard
	'dashboard' => array(
		'vi' => 'Bảng điều khiển',
		'en' => 'Dashboard',
	),


	// Upload
	'choose_file' => array(
		'vi' => 'Chọn file…',
		'en' => 'Choose a file…',
	),
	'upload' => array(
		'vi' => 'Tải lên',
		'en' => 'Upload',
	),

	// Remote
	'remote' => array(
		'vi' => 'Remote',
	),
	'remote_support_link' => array(
		'vi' => 'Remote hỗ trợ các định dạng liên kết sau:',
		'en' => 'Remote support links:',
	),
	'remote_help' => array(
		'vi' => 'Chức năng remote sẽ sao chép 1 file từ Google Drive về '.$site_config['lang']['site_name'].', giúp tránh tình trạng chết link. Nếu là file video, file sau khi sao chép thành công thì cần phải đợi 1 khoảng thời gian để file được sao chép có thể xem được online trên '.$site_config['lang']['site_name'].'. Tuy nhiên trong khi chờ file sao chép xử lý xong thì file đó vẫn có thể xem được online ngay nếu link video remote đó đã được xử lý.',
		'en' => 'Remote function will copy file from Google Drive to '.$site_config['lang']['site_name'].', helps avoid dead links. If is video file, the file after successful replication is need to wait for one period of time to file is copied can be viewed online. However, while waiting for the file copy processing is complete, the file can still be viewed online even if the remote video link that was processed by Google Drive.',
	),
	'remote_input_placeholder' => array(
		'vi' => 'Liên kết file cần remote. (Mỗi dòng 1 liên kết)',
		'en' => 'Link to clone. (Per line a link)',
	),
	'remote_submit' => array(
		'vi' => 'Remote',
		'en' => 'Remote',
	),
	'link_share' => array(
		'vi' => 'Link chia sẻ',
		'en' => 'Link share',
	),
	'link_remote' => array(
		'vi' => 'Link remote',
	),
	'response' => array(
		'vi' => 'Kết quả',
		'en' => 'Response',
	), 
	'embed' => array(
		'vi' => 'Embed',
	),

	// Manager 
	'file_manager' => array(
		'vi' => 'Quản lý file',
		'en' => 'File Manager',
	),
	'minimum_chars' => array(
		'vi' => 'Tối thiểu 3 ký tự',
		'en' => 'Minimum 3 chars',
	),
	'name_folder_placeholder' => array(
		'vi' => 'Nhập tên thư mục',
		'en' => 'Enter name folder',
	),
	'keyword_placeholder' => array(
		'vi' => 'Nhập từ khóa cần tìm…',
		'en' => 'Enter keyword…',
	),
	'create_folder' => array(
		'vi' => 'Tạo thư mục',
		'en' => 'Create folder',
	),
	'search' => array(
		'vi' => 'Tìm kiếm',
		'en' => 'Search',
	),
	'name' => array(
		'vi' => 'Tên',
		'en' => 'Name',
	),
	'thumb' => array(
		'vi' => 'Ảnh',
		'en' => 'Thumb',
	),
	'size' => array(
		'vi' => 'Kích thước',
		'en' => 'Size',
	),
	'date' => array(
		'vi' => 'Ngày',
		'en' => 'Date',
	),
	'status' => array(
		'vi' => 'Trạng thái',
		'en' => 'Status',
	),
	'root_folder' => array(
		'vi' => 'Thư mục gốc',
		'en' => 'Root folder',
	),
	'folder' => array(
		'vi' => 'Thư mục',
		'en' => 'Folder',
	),
	'folder_lock' => array(
		'vi' => 'Đã khóa thư mục',
		'en' => 'Folder locked',
	),
	'file_lock' => array(
		'vi' => 'Đã khóa tệp tin',
		'en' => 'File locked',
	),
	'locked_file' => array(
		'vi' => 'Tệp tin đã bị khóa',
		'en' => 'File is locked',
	),
	'public' => array(
		'vi' => 'Công khai',
		'en' => 'Public',
	),
	'delete_folder' => array(
		'vi' => 'Xóa thư mục',
		'en' => 'Delete folder',
	),
	'delete_file' => array(
		'vi' => 'Xóa tệp tin',
		'en' => 'Delete file',
	),
	'load_more_folder' => array(
		'vi' => 'Tải thêm 5 thư mục',
		'en' => 'Load more 5 folder',
	),
	'load_more_file' => array(
		'vi' => 'Tải thêm 10 dữ liệu',
		'en' => 'Load more 10 files',
	),
	'options' => array(
		'vi' => 'Tác vụ',
		'en' => 'Options',
	),
	'move_files' => array(
		'vi' => 'Di chuyển',
		'en' => 'Move files',
	),
	'delete_files' => array(
		'vi' => 'Xóa',
		'en' => 'Delete files',
	),
	'view' => array(
		'vi' => 'Xem Video',
		'en' => 'View',
	),
	'watch_online' => array(
		'vi' => 'Xem Online',
		'en' => 'Watch Online',
	),
	'view_image' => array(
		'vi' => 'Xem ảnh',
		'en' => 'View image',
	),
	'view_document' => array(
		'vi' => 'Xem tài liệu',
		'en' => 'View document',
	),
	'cannot_view' => array(
		'vi' => 'Không có video',
		'en' => 'Cannot view',
	),

	// File
	'download' => array(
		'vi' => 'Tải xuống',
		'en' => 'Download',
	),
	'play_online' => array(
		'vi' => 'Xem online',
		'en' => 'Play Video',
	),
	'not_available' => array(
		'vi' => 'Không có sẵn',
		'en' => 'Not available',
	),
	'file_information' => array(
		'vi' => 'File Info',
		'en' => 'File Information',
	),
	'folder_information' => array(
		'vi' => 'Thông tin thư mục',
		'en' => 'Folder Information',
	),
	'share' => array(
		'vi' => 'Chia sẻ',
		'en' => 'Share',
	),
	'speed_unlimited' => array(
		'vi' => 'Không giới hạn tốc độ',
		'en' => 'Speed Unlimited',
	),
	'storage_unlimited' => array(
		'vi' => 'Không giới hạn dung lượng',
		'en' => 'Storage Unlimited',
	),
	'password_file_download' => array(
		'vi' => 'Nhập mật khẩu tải để tải tệp tin',
		'en' => 'Enter password to download',
	),
	'folder_locked' => array(
		'vi' => 'Thư mục đã khóa',
		'en' => 'Folder locked',
	),
	'folder_password_placeholder' => array(
		'vi' => 'Nhập mật khẩu để xem danh sách tệp tin',
		'en' => 'Enter password view container',
	),
	'send' => array(
		'vi' => 'Gửi',
		'en' => 'Send',
	),

	'processing' => array(
		'vi' => 'Đang xử lý',
		'en' => 'Processing',
	),
	'file_error' => array(
		'vi' => 'Tệp tin bị lỗi',
		'en' => 'File error',
	),
	'license_violation' => array(
		'vi' => 'Vi phạm bản quyền',
		'en' => 'License violations',
	),
	'update_at' => array(
		'vi' => 'Cập nhập lúc',
		'en' => 'Update at',
	),
	'name_file' => array(
		'vi' => 'Tên tệp tin',
		'en' => 'File name',
	),
	'password' => array(
		'vi' => 'Mật khẩu',
		'en' => 'Password',
	),
	'set_password' => array(
		'vi' => 'Đặt mật khẩu',
		'en' => 'Set password',
	),
	'subscene' => array(
		'vi' => 'Phụ đề',
		'en' => 'Subtitle',
	),
	'subtitle_film' => array(
		'vi' => 'Phụ đề phim',
		'en' => 'Subtitle',
	),
	'copy_to_clipboard' => array(
		'vi' => 'Sao chép vào bộ nhớ tạm',
		'en' => 'Copy To Clipboard',
	),
	'update' => array(
		'vi' => 'Cập nhật',
		'en' => 'Update',
	),
	'close' => array(
		'vi' => 'Đóng',
		'en' => 'Close',
	),

	// Profile
	'profile' => array(
		'vi' => 'Hồ sơ cá nhân',
		'en' => 'Profile',
	),
	'login' => array(
		'vi' => 'Đăng nhập',
		'en' => 'Sign in',
	),
	'logout' => array(
		'vi' => 'Đăng xuất',
		'en' => 'Sign out',
	),
	'notification' => array(
		'vi' => 'Thông báo',
		'en' => 'Notification',
	),
	'view_all' => array(
		'vi' => 'Xem tất cả',
		'en' => 'View all',
	),
	'info_account' => array(
		'vi' => 'Thông tin tài khoản',
		'en' => 'Account infomation',
	),
	'nickname' => array(
		'vi' => 'Nickname',
		'en' => 'Nickname',
	),
	'name_display' => array(
		'vi' => 'Tên hiển thị',
		'en' => 'Display name',
	),
	'avatar' => array(
		'vi' => 'Ảnh đại diện',
		'en' => 'Avatar',
	),
	'gender' => array(
		'vi' => 'Giới tính',
		'en' => 'Gender',
	),
	'male' => array(
		'vi' => 'Nam',
		'en' => 'Male',
	),
	'female' => array(
		'vi' => 'Nữ',
		'en' => 'Female',
	),
	'logo_placeholder' => array(
		'vi' => 'Logo hiện trên player (Kích thước: 64 x 64px)',
		'en' => 'Logo show on player (Size: 64 x 64px)',
	),
	'user_created' => array(
		'vi' => 'Ngày tạo',
		'en' => 'Date created',
	),

//
	'lock_video_view' => array(
		'vi' => 'Video đã khóa, vui lòng nhập mật khẩu để xem video này',
		'en' => 'Video locked, enter password to view this video',
	),
	'lock_video_enter_password' => array(
		'vi' => 'Nhập mật khẩu để xem video',
		'en' => 'Enter password to view this video',
	),

	// Ajax
	'server_offline' => array(
		'vi' => 'Máy chủ đang bảo trì',
		'en' => 'The server is down for maintenance',
	),

	'unable_upload_file' => array(
		'vi' => 'Không thể upload tệp tin này',
		'en' => 'Cannot upload this file',
	),
	'file_copy_success' => array(
		'vi' => 'File đã được sao chép thành công.',
		'en' => 'File copied success ',
	),
	'file_copy_processing' => array(
		'vi' => 'File đang được xử lý.',
		'en' => 'File processing. ',
	),
	'file_copy_fail' => array(
		'vi' => 'Không thể sao chép file này',
		'en' => 'File cannot copy',
	),
	'wrong_password' => array(
		'vi' => 'Sai mật khẩu',
		'en' => 'Wrong password',
	),
	'unable_download_file' => array(
		'vi' => 'Bấm để tải lại',
		'en' => 'This file cannot download!',
	),
	'video_error' => array(
		'vi' => 'Video bị lỗi!',
		'en' => 'Video error!',
	),
	'video_processing' => array(
		'vi' => 'Video đang được xử lý!',
		'en' => 'Video processing!',
	),
	'video_wrong_format' => array(
		'vi' => 'Định dạng file không hợp lệ!',
		'en' => 'Video wrong format!',
	),
	'url_not_invalid' => array(
		'vi' => 'URL không hợp lệ!',
		'en' => 'URL not invalid!',
	),
	'login_fail' => array(
		'vi' => 'Đăng nhập thất bại!',
		'en' => 'Login failed',
	),
	'file_not_found' => array(
		'vi' => 'Tệp tin không tồn tại!',
		'en' => 'File not found!',
	),
	'file_update_success' => array(
		'vi' => 'Cập nhật tệp tin thành công',
		'en' => 'Update file successfully',
	),
	'file_update_fail' => array(
		'vi' => 'Cập nhật tệp tin thất bại',
		'en' => 'Update file failed',
	),
	'file_delete_success' => array(
		'vi' => 'Xóa file thành công',
		'en' => 'Delete file successfully',
	),
	'file_delete_fail' => array(
		'vi' => 'Xóa file thất bại',
		'en' => 'Delete file failed',
	),
	'folder_create_success' => array(
		'vi' => 'Tạo thư mục thành công',
		'en' => 'Create folder successfully',
	),
	'folder_create_fail' => array(
		'vi' => 'Tạo thư mục thất bại',
		'en' => 'Create folder failed',
	),
	'folder_exist' => array(
		'vi' => 'Thư mục đã tồn tại!',
		'en' => 'Folder exist!',
	),
	'folder_create_fail_subfolder' => array(
		'vi' => 'Không thể tạo thư mục mới trong thư mục con!',
		'en' => 'Unable to create a new folder in subfolder!',
	),
	'task_fail' => array(
		'vi' => 'Tác vụ thất bại',
		'en' => 'Task failure',
	),
	'update_folder_success' => array(
		'vi' => 'Cập nhật thư mục thành công',
		'en' => 'Update folder successfully',
	),
	'update_folder_fail' => array(
		'vi' => 'Cập nhật thư mục thất bại',
		'en' => 'Update folder failed',
	),
	'folder_delete_success' => array(
		'vi' => 'Xóa thư mục thành công',
		'en' => 'Delete folder successfully',
	),
	'folder_delete_fail' => array(
		'vi' => 'Xóa thư mục thất bại',
		'en' => 'Delete folder failed',
	),
	'file_move_success' => array(
		'vi' => 'Di chuyển file thành công',
		'en' => 'Move file successfully',
	),
	'file_move_fail' => array(
		'vi' => 'Di chuyển file thất bại',
		'en' => 'Move file failed',
	),
	'files_delete_success' => array(
		'vi' => 'Tất cả các tệp tin đã xóa thành công',
		'en' => 'Delete files successfully',
	),
	'files_delete_success_fail' => array(
		'vi' => 'Một số tệp tin không thể xóa',
		'en' => 'Some files cannot delete',
	),
	'files_delete_fail' => array(
		'vi' => 'Không thể xóa các tệp tin',
		'en' => 'Delete files failed',
	),
	'no_data' => array(
		'vi' => 'Không còn dữ liệu',
		'en' => 'No data',
	),
	'not_found' => array(
		'vi' => 'Không tìm thấy',
		'en' => 'Not found',
	),

















);
//var_dump($site_config['lang']);
?>