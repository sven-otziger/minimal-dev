<?php

namespace Controller;

class BlogController
{

	/**
	 * @param string[] $array
	 */
	public function __construct(array $array)
	{

	}

	public function blogShow($slug)
	{
		echo "blog_show {$slug}";
	}

	public function _controller()
	{
		echo "controller test";
	}

	public function blog_show() {
		require __DIR__ . '/../views/blog.html';
	}

}
