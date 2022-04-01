// Add Class to Element
function addElementClass (id, className) {
  const element = document.getElementById(id)
  element.className += ' ' + className
}

// Remove Class from Element
function removeElementClass (id, className) {
  const element = document.getElementById(id)
  element.className = element.className.replace(className, '')
}

// Generate a popup window using an existing div
function generatePopup (title, content) {
  const titleHtml = title.replace(/<iframe.*?<\/iframe>/g, '').replace(/<script.*?<\/script>/g, '')
  const contentHtml = content.replace(/<iframe.*?<\/iframe>/g, '').replace(/<script.*?<\/script>/g, '')

  // If Title OR Content is empty, return
  if (titleHtml == '' || contentHtml == '') {
    return
  }

  const popupIdName = 'overDiv'
  let isDown = false
  // If popupIdName div already exists, remove it
  if (document.getElementById(popupIdName)) {
    document.getElementById(popupIdName).remove()
  }
  // Create Popup
  const popup = document.createElement('div')
  // Set Div id
  popup.id = popupIdName
  popup.style.position = 'absolute'
  popup.style.zIndex = '111111112'
  document.body.appendChild(popup)
  // remove iframe and script html elements from title and content
  // set popup title and content
  popup.innerHTML = '<div id="popup-title"></div><div id="popup-content"></div>'
  // set popup title and content html elements
  const popupTitle = document.getElementById('popup-title')
  const popupContent = document.getElementById('popup-content')
  // innerHTML for title and content
  popupTitle.innerHTML = titleHtml + ' <span class="popup-close">X</span>'
  popupContent.innerHTML = contentHtml
  const popupClose = document.getElementsByClassName('popup-close')[0]
  // Set Popup Width and Height
  const popupWidth = popupContent.offsetWidth + 20
  const popupHeight = popupContent.offsetHeight + 20
  // Set Style for Popup Elements
  // popup
  popup.style.backgroundColor = '#000000'
  popup.style.border = '1px solid #333333'
  popup.style.boxShadow = '0px 0px 1px #000000'
  popup.style.top = (window.event.y) - (popupHeight / 2) + 'px'
  popup.style.left = (window.event.x) - (popupWidth / 2) + 'px'
  popup.style.minWidth = popupWidth + 'px'
  popup.style.minHeight = popupHeight + 'px'
  // popupTitle
  popupTitle.style.backgroundColor = '#212121'
  popupTitle.style.borderBottom = '1px solid #333333'
  popupTitle.style.color = '#D99D1C'
  popupTitle.style.padding = '5px'
  popupTitle.style.fontSize = '14px'
  popupTitle.style.fontWeight = 'bold'
  popupTitle.style.userSelect = 'none'
  popupTitle.style.display = 'block'
  popupTitle.style.lineHeight = '1.2'
  popupTitle.style.verticalAlign = 'middle'
  // popupContent
  popupContent.style.backgroundColor = '#000000'
  popupContent.style.color = '#ffffff'
  popupContent.style.padding = '5px'
  popupContent.style.fontSize = '12px'
  popupContent.style.display = 'block'
  // popupClose
  popupClose.style.cursor = 'pointer'
  popupClose.style.float = 'right'
  popupClose.style.backgroundColor = '#73241f'
  popupClose.style.border = '1px solid #8f2821'
  popupClose.style.color = '#a88d8d'
  popupClose.style.fontWeight = 'bold'
  popupClose.style.padding = '3px 5px'
  popupClose.style.marginTop = '-4px'
  popupClose.style.marginRight = '-4px'
  // Set Event Listeners
  popupClose.onmouseover = function () {
    popupClose.style.backgroundColor = '#8f2d27'
    popupClose.style.border = '1px solid #962018'
    popupClose.style.color = '#fafafa'
  }
  popupClose.onmouseout = function () {
    popupClose.style.backgroundColor = '#73241f'
    popupClose.style.border = '1px solid #8f2821'
    popupClose.style.color = '#a88d8d'
  }
  popupClose.onclick = function () {
    document.getElementById(popupIdName).remove()
  }
  popupTitle.onmousedown = function () {
    popup.style.cursor = 'move'
    isDown = true
    document.body.style.UserSelect = 'none'
  }
  popupTitle.onmouseup = function () {
    popup.style.cursor = 'default'
    isDown = false
    document.body.style.UserSelect = 'text'
  }
  document.onmousemove = function () {
    if (isDown) {
      popup.style.top = (window.event.y) - (popupTitle.offsetHeight / 2) + 'px'
      popup.style.left = (window.event.x) - (popupTitle.offsetWidth / 2) + 'px'
      // Fix popup position if it goes out of the screen
      if (popup.offsetTop < 0) {
        popup.style.top = 0
      }
      if (popup.offsetLeft < 0) {
        popup.style.left = 0
      }
      if (popup.offsetTop + popup.offsetHeight > window.innerHeight) {
        popup.style.top = window.innerHeight - popup.offsetHeight
      }
      if (popup.offsetLeft + popup.offsetWidth > window.innerWidth) {
        popup.style.left = window.innerWidth - popup.offsetWidth
      }
    }
  }
}

// Generate Popup Window for the given url
function generatePopupWindow (url) {
  if (url.indexOf(window.location.host) !== -1 || url.substring(0, 1) === '/') {
    const xhr = new XMLHttpRequest()
    xhr.open('GET', url, true)
    xhr.onload = function () {
      if (this.status == 200) {
        const title = this.responseText.match(/<title>(.*?)<\/title>/)[1]
        // remove iframe and script html elements from content
        const content = this.responseText.replace(/<iframe.*?<\/iframe>/g, '').replace(/<script.*?<\/script>/g, '')
        generatePopup(title, content)
      } else {
        alert('Error: ' + this.status)
      }
    }
    xhr.send()
  } else {
    alert('Error: Invalid URL')
  }
}
