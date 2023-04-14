import { toast } from 'vue3-toastify'
import 'vue3-toastify/dist/index.css'

export const showToast = (message: string) => {
  toast(message, {
    autoClose: 3000,
    type: toast.TYPE.SUCCESS
  })
}

export const showErrorToast = (message: string) => {
  toast(message, {
    autoClose: 3000,
    type: toast.TYPE.ERROR
  })
}
