import '../css/bootstrap.scss'
import '../css/app.scss'
import '../css/utilities.scss'

import { Collapse, Dropdown, Modal } from 'bootstrap'

function getElements(selector, parentEl){
    parentEl = parentEl || document

    return [].concat(...parentEl.querySelectorAll(selector))
}

function getNextElement(el, selector){
    let a, t = el.nextElementSibling
    while (t) {
        if (t.matches(selector)){
            a = t
            break;
        }

        t = t.nextElementSibling
    }

    return a
}

function mayHaveChildren(checkItem){
    if (checkItem.form) {
      const childrens = getElements(`[data-bs-parent="${checkItem.value}"`, checkItem.form)
      childrens.forEach((children) => {
        children.checked = checkItem.checked
        mayHaveChildren(children)
        children.disabled = checkItem.checked
      })
    }
}

const modalAlert = (relatedEl, data) => {
    const modalEl = document.getElementById('modal-alert')
    const modal = Modal.getOrCreateInstance(modalEl, { backdrop: 'static' })
    const modalBody = modalEl.querySelector('.modal-body')
    const modalFooter = modalEl.querySelector('.modal-footer')
    const dismissModal = (modal) => {
        modal.hide()
    }
    let btnClass = ['btn', 'btn-primary', 'btn-sm']
    if (data.button && data.button.className) {
      btnClass = data.button.className.split(' ')
    }
    const button = document.createElement('button')
    button.classList.add(...btnClass)
    button.innerHTML = (data.button && data.button.text) ? data.button.text : 'OK'
    button.addEventListener('click', (event) => {
        event.preventDefault()
        const callback = (data.button && data.button.callback) ? data.button.callback : dismissModal
        callback.call(this, modal)
    })

    let bodyContent = ''
    if (data.heading) {
      bodyContent = `<h3>${data.heading}</h3>`
    }
    if (data.message) {
      bodyContent = `${bodyContent}<div class="text-secondary">${data.message}</div>`
    }
    modalBody.innerHTML = bodyContent

    modalFooter.innerHTML = ''
    if (data.showCancelButton) {
      const cancelButton = document.createElement('button')
      cancelButton.classList.add(...['btn', 'btn-outline-secondary', 'btn-sm'])
      cancelButton.innerHTML = 'Cancel'
      cancelButton.addEventListener('click', () => {
        dismissModal(modal)
      })
      modalFooter.append(cancelButton)
    }
    modalFooter.append(button)

    modal.show(relatedEl)

    return modal
  }

  const alertAndDelete = (deleteBtn) => {
    modalAlert(deleteBtn, {
      heading: deleteBtn.dataset.heading || 'Sure to Delete?',
      message: deleteBtn.dataset.message || 'It will be permanently deleted and cannot be restored!',
      button: {
        className: 'btn btn-danger btn-sm',
        text: 'Yes, I am Sure',
        callback: async (modal) => {
          getElements('button', modal._element).forEach((btn) => {
            btn.disabled = true
          })

          const f = deleteBtn.form || document.querySelector('#admin-form')
          const url = deleteBtn.dataset.url || f.getAttribute('action') || document.location.href
          const b = new FormData(f)
          b.append('_method', 'DELETE')

          fetch(url, {
            method: 'POST',
            headers: {
                accept: 'application/json'
            },
            body: b
          }).then(async (response) => {
            return {
                status: response.status,
                statusText: response.statusText,
                data: await response.json()
            }
          }).then(response => {
            if (response.data.success){
                document.location.reload()
            } else {
                const msgEl = document.getElementById('message')
                if (msgEl){
                    msgEl.innerHTML = response.data.message || response.statusText
                    msgEl.classList.remove('d-none')
                    msgEl.classList.add(`alert-danger`)
                }

                modal.hide()
            }
          })
        }
      },
      showCancelButton: true
    })
}

const showInlineMessage = (msgEl, message, type) => {
    type = type || 'danger'
    type = type === 'error' ? 'danger':type
    msgEl.classList.remove('d-none')
    msgEl.classList.add(`alert-${type}`)
    msgEl.innerHTML = message
}

window.addEventListener('DOMContentLoaded', () => {
    const forms = getElements('form[method="post"]', document)
    forms.map(form => {
        form.addEventListener('submit', event => {
            event.preventDefault()

            if (form.classList.contains('need-validation')){
                if ( !form.checkValidity()){
                    form.classList.add('was-validated')
                    return
                }
            }

            const btns = getElements('[type="submit"]', form)
            btns.forEach(b => {
                b.disabled = true
            })

            const errEls = getElements('.is-invalid', form)
            errEls.forEach(errEl => {
                errEl.classList.remove('is-invalid')
            })

            let msgEl = form.querySelector(`#message`)
            if ( !msgEl) {
                msgEl = document.createElement('div')
                msgEl.setAttribute('id', 'message')
                msgEl.classList.add(...['alert', 'py-2', 'lh-sm'])
                form.prepend(msgEl)
            }
            msgEl.classList.remove(...['alert-danger', 'alert-success'])
            msgEl.classList.add('d-none')

            fetch(form.action, {
                method: "POST",
                headers: {
                    accept: 'application/json'
                },
                body: new FormData(form)
            }).then(async response => {
                return {
                    status: response.status,
                    statusText: response.statusText,
                    data: await response.json()
                }
            }).then(response => {
                if (response.data.errors){
                    for(const k in response.data.errors){
                        if (k == 'message'){
                            showInlineMessage(msgEl, response.data.errors[k], 'danger')
                        } else {
                            const el = form.querySelector(`[name="${k}"]`)
                            if (el){
                                const invalidFeedbackEl = getNextElement(el, '.invalid-feedback')
                                if (invalidFeedbackEl){
                                    invalidFeedbackEl.innerHTML = response.data.errors[k][0]
                                }
                                el.classList.add('is-invalid')
                            }
                        }
                    }

                    form.classList.remove('was-validated')
                } else if (response.data.success){
                    if (response.data.redirect_to){
                        document.location.href = response.data.redirect_to
                    } else {
                        showInlineMessage(msgEl, response.data.message || 'The Form has been successfully submitted.', 'success')
                    }
                } else if (![200, 422].includes(response.status)){
                    let m = response.data.message || response.statusText
                    if (/CSRF/gi.test(m)){
                        m = `${m} Please reload this page.`
                    }
                    showInlineMessage(msgEl, m, 'danger')
                }
            }).catch(err => {
                showInlineMessage(msgEl, err.message, 'danger')
            }).finally(() => {
                btns.forEach(b => {
                    b.disabled = false
                })
            })
        })
    })

    getElements('[data-bs-toggle="check-all"]', document).map((checkAllEl) => {
        checkAllEl.addEventListener('click', () => {
            const form = checkAllEl.form || document
            const checkItems = getElements('[data-bs-toggle="check-item"]', form)
            checkItems.forEach((checkItem) => {
                checkItem.checked = checkAllEl.checked
                mayHaveChildren(checkItem)
            })
        })
    })

    const checkItemEls = getElements('[data-bs-toggle="check-item"]', document)
    checkItemEls.map((checkItemEl) => {
        checkItemEl.addEventListener('click', () => {
            const form = checkItemEl.form || document
            const checkAllEls = getElements('[data-bs-toggle="check-all"]', form)

            mayHaveChildren(checkItemEl)

            const checkSelected = getElements('[data-bs-toggle="check-item"]:checked', form)

            if (checkSelected.length === 0) {
                checkAllEls.forEach(checkAllEl => {
                    checkAllEl.indeterminate = false
                    checkAllEl.checked = false
                })
            } else if (checkItemEls.length === checkSelected.length) {
                checkAllEls.forEach(checkAllEl => {
                    checkAllEl.indeterminate = false
                    checkAllEl.checked = true
                })
            } else {
                checkAllEls.forEach(checkAllEl => {
                    checkAllEl.indeterminate = true
                    checkAllEl.checked = false
                })
            }
        })
    })

    getElements('[data-bs-toggle="delete-all"]').map((deleteAllBtn) => {
        deleteAllBtn.addEventListener('click', async (event) => {
            event.preventDefault()
            const form = deleteAllBtn.form || document.querySelector('#admin-form')
            if (!form)
                return false;

            if (form.querySelectorAll('[data-bs-toggle="check-item"]:checked').length) {
                alertAndDelete(deleteAllBtn)
            } else {
                modalAlert(deleteAllBtn, {
                    message: 'Please select the item to delete.',
                    button: {
                        className: 'btn btn-warning btn-sm'
                    }
                })
            }
        })
    })

    getElements('[data-bs-toggle="delete-item"]').map((deleteItemBtn) => {
        deleteItemBtn.addEventListener('click', (event) => {
            event.preventDefault()
            const form = deleteItemBtn.form || document.querySelector('#admin-form')
            if (!form)
                return false;
            alertAndDelete(deleteItemBtn)
        })
    })
})