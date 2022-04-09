// noinspection JSDeprecatedSymbols

/**
 * 
 * MIT License
 * 
 * Copyright (c) 2022 Zurret
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 * 
 */

// Generate a popup window using an existing div
function generatePopup(title, content, x = null, y = null) {
  let titleHtml = 'Popup';
  // remove iframe and script html elements from title and content
  if (title !== undefined) {
    titleHtml = title.replace(/<iframe.*?<\/iframe>/g, '').replace(/<script.*?<\/script>/g, '')
  }
  const contentHtml = content.replace(/<iframe.*?<\/iframe>/g, '').replace(/<script.*?<\/script>/g, '')

  // If Title OR Content is empty, return
  if (titleHtml === '' || contentHtml === '') {
    return
  }

  if (x !== null && y !== null) {
    // Set Windows.event.x and .y to the x and y values
    window.event.x = x
    window.event.y = y
  }

  const popupIdName = 'overDiv'
  let isDown = false
  // If popupIdName div already exists, remove it
  if (document.getElementById(popupIdName)) {
    document.getElementById(popupIdName).remove()
  }
  // Create Popup
  const popup = document.createElement('div')
  popup.id = popupIdName
  popup.style.position = 'absolute'
  popup.style.zIndex = '111111112'
  document.body.appendChild(popup)
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
  const popupWidth = popupContent.offsetWidth
  const popupHeight = popupContent.offsetHeight
  // Set Style for Popup Elements
  // popup
  popup.style.backgroundColor = '#f8f8f8'
  popup.style.border = '1px solid #e5e5e5'
  popup.style.boxShadow = '0px 0px 1px #000000'
  popup.style.top = (window.event.y) - (popupHeight / 2) + 'px'
  popup.style.left = (window.event.x) - (popupWidth / 2) + 'px'
  popup.style.minWidth = popupWidth + 'px'
  popup.style.minHeight = popupHeight + 'px'
  // popupTitle
  popupTitle.style.backgroundColor = '#222'
  popupTitle.style.borderBottom = '1px solid #e5e5e5'
  popupTitle.style.color = '#fff'
  popupTitle.style.padding = '5px'
  popupTitle.style.fontSize = '14px'
  popupTitle.style.fontWeight = 'bold'
  popupTitle.style.userSelect = 'none'
  popupTitle.style.display = 'block'
  popupTitle.style.lineHeight = '1.2'
  popupTitle.style.verticalAlign = 'middle'
  // popupClose
  popupClose.style.cursor = 'pointer'
  popupClose.style.float = 'right'
  popupClose.style.backgroundColor = '#f0506e'
  popupClose.style.border = '1px solid #d13b56'
  popupClose.style.color = '#fff'
  popupClose.style.fontWeight = 'bold'
  popupClose.style.padding = '3px 10px'
  popupClose.style.marginTop = '-4px'
  popupClose.style.marginRight = '-4px'
  popupClose.style.marginLeft = '50px'
  // popupContent
  popupContent.style.backgroundColor = '#fff'
  popupContent.style.color = '#666'
  popupContent.style.fontSize = '12px'
  popupContent.style.display = 'block'
  popupContent.style.width = '100%'
  popupContent.style.height = '100%'
  // Set Event Listeners
  popupClose.onmouseover = function () {
    popupClose.style.backgroundColor = '#d13b56'
    popupClose.style.border = '1px solid #d13b56'
    popupClose.style.color = '#fff'
  }
  popupClose.onmouseout = function () {
    popupClose.style.backgroundColor = '#f0506e'
    popupClose.style.border = '1px solid #d13b56'
    popupClose.style.color = '#fff'
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
        popup.style.top = '0px'
      }
      if (popup.offsetLeft < 0) {
        popup.style.left = '0px'
      }
      if (popup.offsetTop + popup.offsetHeight > window.innerHeight) {
        popup.style.top = window.innerHeight - popup.offsetHeight + 'px'
      }
      if (popup.offsetLeft + popup.offsetWidth > window.innerWidth) {
        popup.style.left = window.innerWidth - popup.offsetWidth + 'px'
      }
    }
  }
}

// Generate Popup Window for the given url
function generatePopupWindow(url) {
  const x = window.event.x
  const y = window.event.y
  if (url.indexOf(window.location.host) !== -1 || url.substring(0, 1) === '/') {
    const xhr = new XMLHttpRequest()
    xhr.open('GET', url, true)
    xhr.onload = function () {
      if (this.status === 200) {
        const title = this.responseText.match(/<title>(.*?)<\/title>/)[1]
        // remove iframe and script html elements from content
        const content = this.responseText.replace(/<iframe.*?<\/iframe>/g, '').replace(/<script.*?<\/script>/g, '')
        // generate popup with title and content and windows.event.x and windows.event.y
        generatePopup(title, content, x, y)
      } else {
        alert('Error: ' + this.status)
      }
    }
    xhr.send()
  } else {
    alert('Error: Invalid URL')
  }
}
