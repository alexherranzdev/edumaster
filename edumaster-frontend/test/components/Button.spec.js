import { mount } from '@vue/test-utils'
import { expect, describe, it } from 'vitest'
import Button from '@/components/BaseButton.vue'

describe('Button.vue', () => {
  it('renders with default props', () => {
    const wrapper = mount(Button)
    expect(wrapper.classes()).toContain('bg-primary')
    expect(wrapper.classes()).toContain('text-white')
  })

  it('renders different types correctly', () => {
    const wrapper = mount(Button, {
      props: { type: 'danger' },
    })
    expect(wrapper.classes()).toContain('bg-rose-500')
  })

  it('renders different sizes correctly', () => {
    const wrapper = mount(Button, {
      props: { size: 'lg' },
    })
    expect(wrapper.classes()).toContain('text-lg')
  })

  it('emits click event', async () => {
    const wrapper = mount(Button)
    await wrapper.trigger('click')
    expect(wrapper.emitted()).toHaveProperty('click')
  })
})
