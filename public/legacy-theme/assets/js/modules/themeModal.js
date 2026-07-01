class ThemeModal {
	buttonsOpenModal;
	buttonsCloseModal;
	modalsView = [];
	self;
	instance;
	
	constructor() {
		if(typeof ThemeModal.instance === 'object') {
			return ThemeModal.instance;
		}
		ThemeModal.instance = this;
		this.buttonsOpenModal = document.querySelectorAll('.open-modal');
		this.buttonsCloseModal = document.querySelectorAll('.close-modal');
		self = this;
		return ThemeModal.instance;
	}
	
	createBackground(){
		if(!document.getElementById('modal-background')) {
			let modalBackground = document.createElement('div');
			modalBackground.id = 'modal-background';
			modalBackground.style.position = 'fixed';
			modalBackground.style.left = '0';
			modalBackground.style.right = '0';
			modalBackground.style.top = '0';
			modalBackground.style.bottom = '0';
			modalBackground.style.background = 'black';
			modalBackground.style.opacity = '0.5';
			modalBackground.style.zIndex = '9999';
			document.body.insertBefore(modalBackground,document.getElementById('footer'));
		}
	}
	removeBackground() {
		let bg = document.getElementById('modal-background');
		if (bg != undefined) {
			bg.remove();
		}
	}
	
	openModal(modalId) {
		if(document.getElementById(`modal-${modalId}`)) {
			let modal = document.getElementById(`modal-${modalId}`);
			modal.classList.add('modal-open');
			self.createBackground();
			document.body.addEventListener('mouseup', self.mouseUpHandler);
			self.buttonsCloseModal.forEach(function (el,key){
				el.addEventListener('click', self.closeModal);
			});
		}
	}
	closeModal() {
		let modals = document.querySelectorAll('.theme-modal.modal-open');
		modals.forEach(function (el,key){
			el.classList.remove('modal-open');
		});
		self.removeBackground();
		document.body.removeEventListener('mouseup', self.mouseUpHandler, false);
		self.buttonsCloseModal.forEach(function (el,key){
			el.removeEventListener('click', self.closeModal, false);
		});
	}
	
	openModalHandler(){
		let modalId = this.getAttribute('data-modal');
		if(modalId) {
			if (self.modalsView.hasOwnProperty(modalId)){
				self.modalsView[modalId].props = event.target.attributes;
				let props = self.modalsView[modalId].props;
				let modal = document.getElementById(`modal-${modalId}`);
				self.modalsView[modalId].callback.call(null, modal, props);
			}else{
				self.openModal(modalId);
			}
		}
	}
	mouseUpHandler(e) {
		if (document.querySelector('.theme-modal.modal-open')){
			let activeModal = document.querySelector('.theme-modal.modal-open');
			if(!activeModal.isEqualNode(e.target)  && !activeModal.contains(e.target))
			{
				self.closeModal();
			}
		}
	}
	
	buttonsListener() {
		let th = this;
		this.buttonsOpenModal.forEach(function (el,key){
			el.addEventListener('click', th.openModalHandler.bind(el));
			let modalId = el.getAttribute('data-modal');

		});
	}
	contactFormListener() {
		document.body.addEventListener('wpcf7mailsent', function(){
			self.closeModal();
			self.openModal('success');
			setTimeout(function(){
				self.closeModal();
			}, 3500);
		});
		document.body.addEventListener('wpcf7mailfailed', function(){
			self.closeModal();
			self.openModal('error');
			setTimeout(function(){
				self.closeModal();
			}, 3500);
		});
	}
	
	
	
	init() {
		this.buttonsListener();
		this.contactFormListener();
	}

	static getInstance() {
		if(typeof ThemeModal.instance === 'object') {
			return ThemeModal.instance;
		}
		ThemeModal.instance = this;
		return new ThemeModal();
	}
}


window.ThemeModal = ThemeModal;