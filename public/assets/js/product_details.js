	const inputs = document.querySelectorAll('input[name="color"]');
	
	inputs.forEach(input => {
	    input.addEventListener('change', () => {
	        // Reset all
	        document.querySelectorAll('.color-swatch').forEach(span => {
	            span.style.border = '2px solid #ccc';
	        });
	        document.querySelectorAll('.color-icon').forEach(icon => {
	            icon.style.display = 'none';
	        });
	
	        // Highlight selected
	        const selectedLabel = input.closest('label');
	        selectedLabel.querySelector('.color-swatch').style.border = '3px solid black';
	        selectedLabel.querySelector('.color-icon').style.display = 'block';
	    });
	});
	
	
	
	function toggleAccordion(header) {
	  const content = header.nextElementSibling;
	  const isOpen = content.classList.contains("show");
	  const icon = header.querySelector(".icon");
	
	  // Close all accordions
	  document.querySelectorAll(".accordion-content").forEach(el => el.classList.remove("show"));
	  document.querySelectorAll(".accordion-header .icon").forEach(ic => ic.textContent = "+");
	
	  if (!isOpen) {
	    content.classList.add("show");
	    icon.textContent = "−";
	  }
	}
	






document.addEventListener('DOMContentLoaded', function () {
    const openBtn = document.getElementById('openPrebookModal');
    const modal = document.getElementById('prebookModal');
    const closeBtn = document.getElementById('closePrebookModal');

    if (!modal) {
        console.warn("Modal not found.");
        return;
    }

    const openModal = () => {
        modal.style.display = 'flex';
        document.body.classList.add('modal-open');
        setTimeout(() => {
            const input = document.getElementById('prebookEmail');
            if (input) input.focus();
        }, 100);
    };

    const closeModal = () => {
        modal.style.display = 'none';
        document.body.classList.remove('modal-open');
    };

    // Open modal
    if (openBtn) {
        openBtn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            openModal();
        });
    }

    // Close modal on close button click
    if (closeBtn) {
        closeBtn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            closeModal();
        });
    }

    // Close modal when clicking outside the modal-box
    window.addEventListener('click', function (e) {
        if (e.target === modal) {
            closeModal();
        }
    });

    // Close modal on Escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });
});


	