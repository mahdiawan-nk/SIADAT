class ResizeWithPopup extends window.ImageResize.BaseModule {
  onCreate() {
    // track resize handles
    this.boxes = [];

    // add 4 resize handles
    this.addBox('nwse-resize'); // top left
    this.addBox('nesw-resize'); // top right
    this.addBox('nwse-resize'); // bottom right
    this.addBox('nesw-resize'); // bottom left

    this.positionBoxes();

    // Create popup box for custom width and height input
    this.createPopupBox();
  }

  onDestroy() {
    // reset drag handle cursors
    this.setCursor('');
    // Remove popup box
    if (this.popupBox) {
      this.popupBox.remove();
    }
  }

  positionBoxes() {
    const handleXOffset = `${-parseFloat(this.options.handleStyles.width) / 2}px`;
    const handleYOffset = `${-parseFloat(this.options.handleStyles.height) / 2}px`;

    // set the top and left for each drag handle
    [
      { left: handleXOffset, top: handleYOffset },        // top left
      { right: handleXOffset, top: handleYOffset },       // top right
      { right: handleXOffset, bottom: handleYOffset },    // bottom right
      { left: handleXOffset, bottom: handleYOffset },     // bottom left
    ].forEach((pos, idx) => {
      Object.assign(this.boxes[idx].style, pos);
    });
  }

  addBox(cursor) {
    // create div element for resize handle
    const box = document.createElement('div');

    // Star with the specified styles
    Object.assign(box.style, this.options.handleStyles);
    box.style.cursor = cursor;

    // Set the width/height to use 'px'
    box.style.width = `${this.options.handleStyles.width}px`;
    box.style.height = `${this.options.handleStyles.height}px`;

    // listen for mousedown on each box
    box.addEventListener('mousedown', this.handleMousedown, false);
    // add drag handle to document
    this.overlay.appendChild(box);
    // keep track of drag handle
    this.boxes.push(box);
  }

  handleMousedown = (evt) => {
    // note which box
    this.dragBox = evt.target;
    // note starting mousedown position
    this.dragStartX = evt.clientX;
    // store the width before the drag
    this.preDragWidth = this.img.width || this.img.naturalWidth;
    // set the proper cursor everywhere
    this.setCursor(this.dragBox.style.cursor);
    // listen for movement and mouseup
    document.addEventListener('mousemove', this.handleDrag, false);
    document.addEventListener('mouseup', this.handleMouseup, false);
  }

  handleMouseup = () => {
    // reset cursor everywhere
    this.setCursor('');
    // stop listening for movement and mouseup
    document.removeEventListener('mousemove', this.handleDrag);
    document.removeEventListener('mouseup', this.handleMouseup);
  }

  handleDrag = (evt) => {
    if (!this.img) {
      // image not set yet
      return;
    }
    // update image size
    const deltaX = evt.clientX - this.dragStartX;
    if (this.dragBox === this.boxes[0] || this.dragBox === this.boxes[3]) {
      // left-side resize handler; dragging right shrinks image
      this.img.width = Math.round(this.preDragWidth - deltaX);
    } else {
      // right-side resize handler; dragging right enlarges image
      this.img.width = Math.round(this.preDragWidth + deltaX);
    }
    this.requestUpdate();
  }

  setCursor(value) {
    [
      document.body,
      this.img,
    ].forEach((el) => {
      el.style.cursor = value;   // eslint-disable-line no-param-reassign
    });
  }

  createPopupBox() {
    // Create popup box element
    this.popupBox = document.createElement('div');
    this.popupBox.style.position = 'absolute';
    this.popupBox.style.background = 'white';
    this.popupBox.style.border = '1px solid black';
    this.popupBox.style.padding = '10px';
    this.popupBox.style.zIndex = '1000';
    this.popupBox.style.display = 'none'; // Hide by default

    // Create input elements for width and height
    const widthLabel = document.createElement('label');
    widthLabel.innerText = 'Width:';
    const widthInput = document.createElement('input');
    widthInput.type = 'number';
    widthInput.value = this.img.width || this.img.naturalWidth;

    const heightLabel = document.createElement('label');
    heightLabel.innerText = 'Height:';
    const heightInput = document.createElement('input');
    heightInput.type = 'number';
    heightInput.value = this.img.height || this.img.naturalHeight;

    // Add event listeners to update image size
    widthInput.addEventListener('input', () => {
      this.img.width = widthInput.value;
      this.requestUpdate();
    });

    heightInput.addEventListener('input', () => {
      this.img.height = heightInput.value;
      this.requestUpdate();
    });

    // Append elements to popup box
    this.popupBox.appendChild(widthLabel);
    this.popupBox.appendChild(widthInput);
    this.popupBox.appendChild(document.createElement('br'));
    this.popupBox.appendChild(heightLabel);
    this.popupBox.appendChild(heightInput);

    // Append popup box to overlay
    this.overlay.appendChild(this.popupBox);

    // Show popup box on image click
    this.img.addEventListener('click', () => {
      this.togglePopupBox();
    });
  }

  togglePopupBox() {
    if (this.popupBox.style.display === 'none') {
      const rect = this.img.getBoundingClientRect();
      this.popupBox.style.left = `${rect.left}px`;
      this.popupBox.style.top = `${rect.bottom + window.scrollY}px`;
      this.popupBox.style.display = 'block';
    } else {
      this.popupBox.style.display = 'none';
    }
  }
}