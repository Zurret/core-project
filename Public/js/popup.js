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
  document.body.appendChild(popup)
  // remove iframe and script html elements from title and content
  // set popup title and content
  popup.innerHTML = '<div id="popup-title"></div><div id="popup-content"></div>'
  // set popup title and content html elements
  const popupTitle = document.getElementById('popup-title')
  const popupContent = document.getElementById('popup-content')
  // innerHTML for title and content
  popupTitle.innerHTML = titleHtml + ' <span class="popup-close">[<span class="popup-cross">X</span>]</span>'
  popupContent.innerHTML = contentHtml
  // Set Popup Width and Height
  const popupWidth = popupContent.offsetWidth + 20
  const popupHeight = popupContent.offsetHeight + 20
  // Position the popup window over mouse cursor
  popup.style.top = (window.event.y) - (popupHeight / 2) + 'px'
  popup.style.left = (window.event.x) - (popupWidth / 2) + 'px'
  // Show the popup window
  popup.style.display = 'block'
  popup.style.visibility = 'visible'
  // Show the popup window on top of other elements
  popup.style.zIndex = '111111112'
  // Move the popup window with click
  popupTitle.onmousedown = function () {
    popup.style.cursor = 'move'
    isDown = true
    // Set all no selectable elements to unselectable
    document.body.style.UserSelect = 'none'
  }
  popupTitle.onmouseup = function () {
    popup.style.cursor = 'default'
    isDown = false
    // Set all no selectable elements to unselectable
    document.body.style.UserSelect = 'text'
  }
  popup.onmousemove = function () {
    if (isDown) {
      popup.style.top = (window.event.y) - (popupHeight / 2) + 'px'
      popup.style.left = (window.event.x) - (popupWidth / 2) + 'px'
      // Don't move the popup window out of the screen
      if (window.event.x < 0) {
        popup.style.left = '0px'
      }
      if (window.event.y < 0) {
        popup.style.top = '0px'
      }
      if (window.event.x > window.innerWidth) {
        popup.style.left = window.innerWidth - popupWidth + 'px'
      }
      if (window.event.y > window.innerHeight) {
        popup.style.top = window.innerHeight - popupHeight + 'px'
      }
    }
  }
  // Close the popup window
  const popupClose = document.getElementsByClassName('popup-cross')[0]
  popupClose.onclick = function () {
    popup.style.display = 'none'
    popup.style.visibility = 'hidden'
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
