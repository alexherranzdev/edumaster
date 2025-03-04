import { mount } from '@vue/test-utils'
import { createPinia, setActivePinia } from 'pinia'
import { expect, describe, it, beforeEach } from 'vitest'
import LoginView from '@/views/LoginView.vue'

describe('LoginView.vue', () => {
  beforeEach(() => {
    setActivePinia(createPinia())
  })

  it('renders login form', () => {
    const wrapper = mount(LoginView)
    expect(wrapper.find('input[type="text"]').exists()).toBe(true)
    expect(wrapper.find('input[type="password"]').exists()).toBe(true)
    expect(wrapper.find('button').text()).toBe('Entrar')
  })

  it('updates email and password fields', async () => {
    const wrapper = mount(LoginView)
    const emailInput = wrapper.find('input[type="text"]')
    const passwordInput = wrapper.find('input[type="password"]')

    await emailInput.setValue('test@example.com')
    await passwordInput.setValue('password123')

    expect(emailInput.element.value).toBe('test@example.com')
    expect(passwordInput.element.value).toBe('password123')
  })

  it('shows error message when fields are empty', async () => {
    const wrapper = mount(LoginView)
    const button = wrapper.find('button')

    await button.trigger('click')
    expect(wrapper.text()).toContain('Por favor, rellena todos los campos')
  })
})
