<?php // interfaces to implement the Observer pattern.

	// Observer interface
	interface Observer{
		public function update(Subject $subject);
	}

	// Subject interface
	interface Subject {
		public function register(Observer $observer);
		public function unregister(Observer $observer);
		public function notify();
	}


