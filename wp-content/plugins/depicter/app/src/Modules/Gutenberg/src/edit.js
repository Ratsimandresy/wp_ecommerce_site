/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-block-editor/#useBlockProps
 */
import {InspectorControls, useBlockProps} from '@wordpress/block-editor';

// import ServerSideRender from '@wordpress/server-side-render';
import {Panel, PanelBody, PanelRow, SelectControl,} from '@wordpress/components';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

import logo from './light-logo.svg';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @param  object               attributes
 * @param  object.attributes
 * @param  setAttributes
 * @param  object.setAttributes
 * @return {JSX.Element[]}
 */
export default function Edit( { attributes, setAttributes } ) {
	const blockProps = useBlockProps();

	function updateID( newID ) {
		setAttributes( { id: newID } );
	}

	function fetchSlider( sliderID ) {
		fetch(ajaxurl + '?action=depicter/document/preview&status=publish&ID=' + sliderID, {
			method: 'GET', // or 'PUT'
			headers: {
				'Content-Type': 'text/html',
			}
		})
			.then(function (response) {
				return response.text();
			})
			.then(function (html) {
				let depicterContentWrapper = document.querySelector('.depicter-content');
				depicterContentWrapper.innerHTML = html;
			})
			.catch(function () {
				console.log('error encountered');
			});
	}

	function getSliderTitle( sliderID ) {
		let sliderTitle = '';
		sliderTitle = depicterSliders.list.map( function (item) {
			if ( item.value == sliderID ) {
				return item.label;
			}

		});
		return sliderTitle ? sliderTitle : 'Slider label does not found';
	}

	return (
		<>
			<InspectorControls key="setting">
				<Panel header="Depicter">
					<PanelBody title="Depicter Settings" initialOpen={ true }>
						<PanelRow>
							<SelectControl
								label="Slider"
								value={ attributes.id }
								options={ depicterSliders.list }
								onChange={ updateID }
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
			</InspectorControls>
			<div { ...blockProps }>
				<div className="dep-widget-wrapper">
					<img src={logo} alt="logo"/>
					<span> { getSliderTitle(attributes.id) } </span>
				</div>
			</div>
		</>
	);
}
