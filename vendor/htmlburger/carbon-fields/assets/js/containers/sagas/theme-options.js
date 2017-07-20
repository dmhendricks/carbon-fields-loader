/**
 * The external dependencies.
 */
import $ from 'jquery';
import { isEmpty } from 'lodash';
import { take, call, select, put, fork } from 'redux-saga/effects';

/**
 * The internal dependencies.
 */
import { createScrollChannel, createSubmitChannel } from 'lib/events';

import { getContainersByType } from 'containers/selectors';
import { validateAllContainers, submitForm } from 'containers/actions';
import { TYPE_THEME_OPTIONS } from 'containers/constants';

/**
 * Handle the sticky position of the actions panel.
 *
 * @return {void}
 */
export function* workerStickyPanel() {
	const channel = yield call(createScrollChannel, window);
	const $container = $('.carbon-box:first');
	const $panel = $('#postbox-container-1');
	const $bar = $('#wpadminbar');

	while (true) {
		const { value } = yield take(channel);
		const offset = $bar.height() + 10;
		const threshold = $container.offset().top - offset;

		// In some situations the threshold is negative number because
		// the container element isn't rendered yet.
		if (threshold > 0) {
			$panel
				.toggleClass('fixed', value >= threshold)
				.css('top', offset);
		}
	}
}

/**
 * Handle the form submission.
 *
 * @return {void}
 */
export function* workerFormSubmit() {
	const channel = yield call(createSubmitChannel, 'form#theme-options-form');

	while (true) {
		const { event } = yield take(channel);

		yield put(submitForm(event));
		yield put(validateAllContainers(event));
	}
}

/**
 * Start to work.
 *
 * @param  {Object} store
 * @return {void}
 */
export default function* foreman(store) {
	const containers = yield select(getContainersByType, TYPE_THEME_OPTIONS);

	// Nothing to do.
	if (isEmpty(containers)) {
		return;
	}

	// Start the workers.
	yield fork(workerStickyPanel);
	yield fork(workerFormSubmit);
}
