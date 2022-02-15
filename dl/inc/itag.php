<?php 
	$formats_itag = array(
        5 	=> array('ext' => 'flv',	'width' => 320, 	'height' => 240, 	'format_note' => '',	'vcodec' => 'h263',		'info' => 'Sorenson H.263/MP3 64kbit/s'),
        6 	=> array('ext' => 'flv',	'width' => 450, 	'height' => 270, 	'format_note' => '',	'vcodec' => 'h263', 	'info' => 'Sorenson H.263/MP3 64kbit/s'),
        13	=> array('ext' => '3gp',											'format_note' => '',	'info' => 'MPEG-4 Visual/AAC N/A'),
        17 	=> array('ext' => '3gp',	'width' => 176,		'height' => 144,	'format_note' => '',	'info' => 'MPEG-4 Visual/AAC 24kbit/s'),
        18 	=> array('ext' => 'mp4',	'width' => 640,		'height' => 360,	'format_note' => '',	'vcodec' => 'h264',		'info' => 'H.264/AAC 96kbit/s'),
        22 	=> array('ext' => 'mp4',	'width' => 1280,	'height' => 720,	'format_note' => '',	'vcodec' => 'h264',		'info' => 'H.264/AAC 192kbit/s'),
        34 	=> array('ext' => 'flv',	'width' => 640,		'height' => 360,	'format_note' => '',	'vcodec' => 'h264',		'info' => 'H.264/AAC 128kbit/s'),
        35 	=> array('ext' => 'flv',	'width' => 854,		'height' => 480,	'format_note' => '',	'vcodec' => 'h264', 	'info' => 'H.264/AAC 128kbit/s'),
        36 	=> array('ext' => '3gp',	'width' => 320, 	'height' => 240, 	'format_note' => '',	'info' => 'MPEG-4 Visual/AAC 36kbit/s'),
        37 	=> array('ext' => 'mp4',	'width' => 1920, 	'height' => 1080, 	'format_note' => '',	'vcodec' => 'h264', 	'info' => 'H.264/AAC 128kbit/s'),
        38 	=> array('ext' => 'mp4',	'width' => 4096, 	'height' => 3072, 	'format_note' => '',	'vcodec' => 'h264', 	'info' => 'H.264/AAC 128kbit/s'),
        43 	=> array('ext' => 'webm',	'width' => 640, 	'height' => 360, 	'format_note' => '',	'vcodec' => 'vp8', 		'info' => 'VP8/Vorbis 128kbit/s'),
        44 	=> array('ext' => 'webm',	'width' => 854, 	'height' => 480, 	'format_note' => '',	'vcodec' => 'vp8', 		'info' => 'VP8/Vorbis 128kbit/s'),
        45 	=> array('ext' => 'webm',	'width' => 1280, 	'height' => 720, 	'format_note' => '',	'vcodec' => 'vp8', 		'info' => 'VP8/Vorbis 192kbit/s'),
        46 	=> array('ext' => 'webm',	'width' => 1920, 	'height' => 1080,	'format_note' => '',	'vcodec' => 'vp8', 		'info' => 'VP8/Vorbis 192kbit/s'),
        59 	=> array('ext' => 'mp4',	'width' => 854, 	'height' => 480, 	'format_note' => '',	'info' => ''),
        78 	=> array('ext' => 'mp4',	'width' => 640, 	'height' => 360, 	'format_note' => '',	'info' => ''),

        # 3d videos
        82 	=> array('ext' => 'mp4',	'width' => 640, 	'height' => 360, 	'format_note' => '3D', 'vcodec' => 'h264', 'preference' => -20, 'info' => 'H.264/AAC 96kbit/s'),
        83 	=> array('ext' => 'mp4',	'width' => 854, 	'height' => 480, 	'format_note' => '3D', 'vcodec' => 'h264', 'preference' => -20, 'info' => 'H.264/AAC 96kbit/s'),
        84 	=> array('ext' => 'mp4',	'width' => 1280, 	'height' => 720, 	'format_note' => '3D', 'vcodec' => 'h264', 'preference' => -20, 'info' => 'H.264/AAC 192kbit/s'),
        85 	=> array('ext' => 'mp4',	'width' => 1920, 	'height' => 1080,	'format_note' => '3D', 'vcodec' => 'h264', 'preference' => -20, 'info' => 'H.264/AAC 192kbit/s'),
        100 => array('ext' => 'webm',	'width' => 640, 	'height' => 360, 	'format_note' => '3D', 'vcodec' => 'vp8', 'preference' => -20, 'info' => 'VP8/Vorbis 128kbit/s'),
        101 => array('ext' => 'webm',	'width' => 854, 	'height' => 480, 	'format_note' => '3D', 'vcodec' => 'vp8', 'preference' => -20, 'info' => 'VP8/Vorbis 192kbit/s'),
        102 => array('ext' => 'webm',	'width' => 1280, 	'height' => 720, 	'format_note' => '3D', 'vcodec' => 'vp8', 'preference' => -20, 'info' => 'VP8/Vorbis 192kbit/s'),

        # Apple HTTP Live Streaming
        92 	=> array('ext' => 'mp4',	'width' => 400, 	'height' => 240, 	'format_note' => 'HLS', 'vcodec' => 'h264', 'preference' => -10, 'info' => 'H.264/AAC 48kbit/s'), //ts
        93 	=> array('ext' => 'mp4',	'width' => 640, 	'height' => 360, 	'format_note' => 'HLS', 'vcodec' => 'h264', 'preference' => -10, 'info' => 'H.264/AAC 128kbit/s'), //ts
        94 	=> array('ext' => 'mp4',	'width' => 854, 	'height' => 480, 	'format_note' => 'HLS', 'vcodec' => 'h264', 'preference' => -10, 'info' => 'H.264/AAC 128kbit/s'), //ts
        95 	=> array('ext' => 'mp4',	'width' => 1280,	'height' => 720, 	'format_note' => 'HLS', 'vcodec' => 'h264', 'preference' => -10, 'info' => 'H.264/AAC 256kbit/s'), //ts
        96 	=> array('ext' => 'mp4',	'width' => 1920,	'height' => 1080,	'format_note' => 'HLS', 'vcodec' => 'h264', 'preference' => -10, 'info' => 'H.264/AAC 256kbit/s'), // ts
        132 => array('ext' => 'mp4',	'width' => 400, 	'height' => 240, 	'format_note' => 'HLS', 'vcodec' => 'h264', 'preference' => -10, 'info' => ''),
        151 => array('ext' => 'mp4',	'width' => '', 		'height' => 72,		'format_note' => 'HLS', 'vcodec' => 'h264', 'preference' => -10, 'info' => ''),

        # DASH mp4 video
        133 => array('ext' => 'mp4',	'width' => 426, 	'height' => 240, 	'format_note' => 'DASH video', 'vcodec' => 'h264', 'acodec' => 'none', 'preference' => -40, 'info' => 'H.264'),
        134 => array('ext' => 'mp4',	'width' => 640, 	'height' => 360, 	'format_note' => 'DASH video', 'vcodec' => 'h264', 'acodec' => 'none', 'preference' => -40, 'info' => 'H.264'),
        135 => array('ext' => 'mp4',	'width' => 854, 	'height' => 480, 	'format_note' => 'DASH video', 'vcodec' => 'h264', 'acodec' => 'none', 'preference' => -40, 'info' => 'H.264'),
        136 => array('ext' => 'mp4',	'width' => 1280,	'height' => 720, 	'format_note' => 'DASH video', 'vcodec' => 'h264', 'acodec' => 'none', 'preference' => -40, 'info' => 'H.264'),
        137 => array('ext' => 'mp4',	'width' => 1920,	'height' => 1080, 	'format_note' => 'DASH video', 'vcodec' => 'h264', 'acodec' => 'none', 'preference' => -40, 'info' => 'H.264'),
        138 => array('ext' => 'mp4',	'width' => 'up 7680',	'height' => 'up 4320',	'format_note' => 'DASH video', 'vcodec' => 'h264', 'acodec' => 'none', 'preference' => -40, 'info' => 'H.264 (Height can vary)'),  # Height can vary (https://github.com/rg3/youtube-dl/issues/4559) bit rate 15.6 Mbps/s
        160 => array('ext' => 'mp4',	'width' => 256, 	'height' => 144,	'format_note' => 'DASH video', 'vcodec' => 'h264', 'acodec' => 'none', 'preference' => -40, 'info' => 'H.264'),
        264 => array('ext' => 'mp4',	'width' => 1920,	'height' => 1440,	'format_note' => 'DASH video', 'vcodec' => 'h264', 'acodec' => 'none', 'preference' => -40, 'info' => 'H.264'),
        298 => array('ext' => 'mp4',	'width' => 1280,	'height' => 720, 	'format_note' => 'DASH video', 'acodec' => 'none', 'preference' => -40, 'fps' => 60, 'vcodec' => 'h264', 'info' => 'H.264'),
        299 => array('ext' => 'mp4',	'width' => 1920,	'height' => 1080,	'format_note' => 'DASH video', 'acodec' => 'none', 'preference' => -40, 'fps' => 60, 'vcodec' => 'h264', 'info' => 'H.264'),
        266 => array('ext' => 'mp4',	'width' => 3840,	'height' => 2160,	'format_note' => 'DASH video', 'acodec' => 'none', 'preference' => -40, 'vcodec' => 'h264', 'info' => ''),

        # Dash webm
        167 => array('ext' => 'webm',	'width' => 640,		'height' => 360,	'format_note' => 'DASH video', 'acodec' => 'none', 'container' => 'webm', 'vcodec' => 'vp8', 'preference' => -40, 'info' => ''),
        168 => array('ext' => 'webm',	'width' => 854, 	'height' => 480, 	'format_note' => 'DASH video', 'acodec' => 'none', 'container' => 'webm', 'vcodec' => 'vp8', 'preference' => -40, 'info' => ''),
        169 => array('ext' => 'webm',	'width' => 1280,	'height' => 720,	'format_note' => 'DASH video', 'acodec' => 'none', 'container' => 'webm', 'vcodec' => 'vp8', 'preference' => -40, 'info' => ''),
        170 => array('ext' => 'webm',	'width' => 1920,	'height' => 1080,	'format_note' => 'DASH video', 'acodec' => 'none', 'container' => 'webm', 'vcodec' => 'vp8', 'preference' => -40, 'info' => ''),
        218 => array('ext' => 'webm',	'width' => 854, 	'height' => 480,	'format_note' => 'DASH video', 'acodec' => 'none', 'container' => 'webm', 'vcodec' => 'vp8', 'preference' => -40, 'info' => ''),
        219 => array('ext' => 'webm',	'width' => 854, 	'height' => 480,	'format_note' => 'DASH video', 'acodec' => 'none', 'container' => 'webm', 'vcodec' => 'vp8', 'preference' => -40, 'info' => ''),
        278 => array('ext' => 'webm', 	'width' => 256,		'height' => 144, 	'format_note' => 'DASH video', 'acodec' => 'none', 'preference' => -40, 'container' => 'webm', 'vcodec' => 'vp9', 'info' => 'VP9'),
        242 => array('ext' => 'webm', 	'width' => 320,		'height' => 240, 	'format_note' => 'DASH video', 'vcodec' => 'vp9', 'acodec' => 'none', 'preference' => -40, 'info' => 'VP9'),
        243 => array('ext' => 'webm',	'width' => 640, 	'height' => 360, 	'format_note' => 'DASH video', 'vcodec' => 'vp9', 'acodec' => 'none', 'preference' => -40, 'info' => 'VP9'),
        244 => array('ext' => 'webm',	'width' => 854, 	'height' => 480, 	'format_note' => 'DASH video', 'vcodec' => 'vp9', 'acodec' => 'none', 'preference' => -40, 'info' => 'VP9'),
        245 => array('ext' => 'webm',	'width' => 854, 	'height' => 480, 	'format_note' => 'DASH video', 'vcodec' => 'vp9', 'acodec' => 'none', 'preference' => -40, 'info' => 'VP9'),
        246 => array('ext' => 'webm',	'width' => 854, 	'height' => 480, 	'format_note' => 'DASH video', 'vcodec' => 'vp9', 'acodec' => 'none', 'preference' => -40, 'info' => 'VP9'),
        247 => array('ext' => 'webm',	'width' => 1280, 	'height' => 720, 	'format_note' => 'DASH video', 'vcodec' => 'vp9', 'acodec' => 'none', 'preference' => -40, 'info' => 'VP9'),
        248 => array('ext' => 'webm',	'width' => 1920, 	'height' => 1080, 	'format_note' => 'DASH video', 'vcodec' => 'vp9', 'acodec' => 'none', 'preference' => -40, 'info' => 'VP9'),
        271 => array('ext' => 'webm',	'width' => 2560, 	'height' => 1440, 	'format_note' => 'DASH video', 'vcodec' => 'vp9', 'acodec' => 'none', 'preference' => -40, 'info' => 'VP9'),
        # itag 272 videos are either 3840x2160 (e.g. RtoitU2A-3E) or 7680x4320 (sLprVF6d7Ug)
        272 => array('ext' => 'webm',	'width' => 3840, 	'height' => 2160, 	'format_note' => 'DASH video', 'acodec' => 'none', 'preference' => -40, 'info' => ''),
        302 => array('ext' => 'webm',	'width' => 1280, 	'height' => 720, 	'format_note' => 'DASH video', 'acodec' => 'none', 'preference' => -40, 'fps' => 60, 'vcodec' => 'vp9', 'info' => 'VP9'),
        303 => array('ext' => 'webm',	'width' => 1920, 	'height' => 1080, 	'format_note' => 'DASH video', 'acodec' => 'none', 'preference' => -40, 'fps' => 60, 'vcodec' => 'vp9', 'info' => 'VP9'),
        308 => array('ext' => 'webm',	'width' => 1920, 	'height' => 1440, 	'format_note' => 'DASH video', 'acodec' => 'none', 'preference' => -40, 'fps' => 60, 'vcodec' => 'vp9', 'info' => 'VP9'),
        313 => array('ext' => 'webm',	'width' => 3840, 	'height' => 2160, 	'format_note' => 'DASH video', 'acodec' => 'none', 'preference' => -40, 'vcodec' => 'vp9', 'info' => 'VP9'),
        315 => array('ext' => 'webm', 	'width' => 3840, 	'height' => 2160, 	'format_note' => 'DASH video', 'acodec' => 'none', 'preference' => -40, 'fps' => 60, 'vcodec' => 'vp9', 'info' => 'VP9'),

        # Dash webm audio
        171 => array('ext' => 'webm', 'vcodec' => 'none', 'format_note' => 'DASH audio', 'abr' => 128, 'preference' => -50, 'info' => 'Vorbis 128kbit/s'),
        172 => array('ext' => 'webm', 'vcodec' => 'none', 'format_note' => 'DASH audio', 'abr' => 256, 'preference' => -50, 'info' => 'Vorbis 256kbit/s'),
        
		# Dash mp4 audio
        139 => array('ext' => 'm4a', 'format_note' => 'DASH audio', 'acodec' => 'aac', 'vcodec' => 'none', 'abr' => 48, 'preference' => -50, 'container' => 'm4a_dash', 'info' => 'AAC 48kbit/s'),
        140 => array('ext' => 'm4a', 'format_note' => 'DASH audio', 'acodec' => 'aac', 'vcodec' => 'none', 'abr' => 128, 'preference' => -50, 'container' => 'm4a_dash', 'info' => 'AAC 128kbit/s'),
        141 => array('ext' => 'm4a', 'format_note' => 'DASH audio', 'acodec' => 'aac', 'vcodec' => 'none', 'abr' => 256, 'preference' => -50, 'container' => 'm4a_dash', 'info' => 'AAC 256kbit/s'),

        # Dash webm audio with opus inside
        249 => array('ext' => 'webm', 'vcodec' => 'none', 'format_note' => 'DASH audio', 'acodec' => 'opus', 'abr' => 50, 'preference' => -50, 'info' => ''),
        250 => array('ext' => 'webm', 'vcodec' => 'none', 'format_note' => 'DASH audio', 'acodec' => 'opus', 'abr' => 70, 'preference' => -50, 'info' => ''),
        251	=> array('ext' => 'webm', 'vcodec' => 'none', 'format_note' => 'DASH audio', 'acodec' => 'opus', 'abr' => 160, 'preference' => -50, 'info' => ''),

        # RTMP (unnamed)
        '_rtmp' => array('protocol' => 'rtmp'),
    );

	?>