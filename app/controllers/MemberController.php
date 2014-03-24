<?php

class MemberController extends BaseController {
	
	//THIS CONTROLLER SERVES FUNCTIONS FOR MEMBERS
	public function __construct(){
		$this->beforeFilter(function(){
			if( Auth::guest() ){
				return Redirect::to('user');
			}
		});
	}
	
	public function getIndex(){
		return Redirect::to('member/mystories');
	}
	
	public function getMystories(){
		$uid = Auth::user()->user_id;
		
		$pending = array();
		$merged = array();
		$retired = array();
		
		$ipending = 0;
		$imerged = 0;
		$iretired = 0;
		
		$contributions = User::find($uid)->contributions->toArray();
		
		foreach ( $contributions as $single_contribution ) {
			if ( $single_contribution['status'] === 1 ) {
				//so this is a pending contribution...
				$pending[$ipending] = $single_contribution;
				$paragraph = Contribution::find($single_contribution['cont_id'])->paragraph ;
				
					//Prepares the author details
				$pending[$ipending]['story']  = ProRetrieve::storyByContribution( $single_contribution['cont_id'] ) ;
				
					//Prepares the dropdown piece showing edits
				$change_sample = $paragraph['content'];
				$contribution_parts = Contribution::find($single_contribution['cont_id'])->contributionparts ;
				foreach ($contribution_parts as $part ) {
					$change_sample = EasyParagraph::appendChange($change_sample, $part, true);
				}
				$pending[$ipending]['change_sample'] = EasyParagraph::htmlreadify( EasyParagraph::untrack($change_sample) );
				
				$ipending++;
				
			} else if ( $single_contribution['status'] === 2 ) {
				//so this is a merged contribution...
				$merged[$imerged] = $single_contribution;
				
					//Prepares the author details
				$merged[$imerged]['story'] = ProRetrieve::storyByContribution( $single_contribution['cont_id'] ) ;
				
				$imerged++;
				
			} else if ( $single_contribution['status'] === 3 ) {
				//so this is a rejected contribution
				$retired[$iretired] = $single_contribution;
				
					//Prepares the author details
				$retired[$iretired]['story'] = ProRetrieve::storyByContribution( $single_contribution['cont_id'] ) ;
				
				$iretired++;
				
			}
		}

		return View::make('member/story/main')
			->with(array(
				'stories'	=> User::find($uid)->directing,
				'pending' => $pending,
				'merged' => $merged,
				'retired' => $retired
				)
			);
	}
	
	public function getModerate($sid){
		//only directors are allowed to moderate this story
		if ( ProCheck::isDirector($sid) ) {
			$pending = array();
			$merged = array();
			$retired = array();
			
			$ipending = 0;
			$imerged = 0;
			$iretired = 0;
			
			$contributions = ProRetrieve::contributionsByStory($sid, 'desc');

			foreach ( $contributions as $single_contribution ) {
				$single_contribution = (array)$single_contribution;

				if ( $single_contribution['status'] === 1 ) {
					//so this is a pending contribution...
					$pending[$ipending] = $single_contribution;
					$paragraph = Contribution::find($single_contribution['cont_id'])->paragraph ;
					
						//Prepares the author details
					$pending[$ipending]['author']  = Contribution::find($single_contribution['cont_id'])->author ;
					
						//Prepares the dropdown piece showing edits
					$change_sample = $paragraph['content'];
					$contribution_parts = Contribution::find($single_contribution['cont_id'])->contributionparts ;
					foreach ($contribution_parts as $part ) {
						$change_sample = EasyParagraph::appendChange($change_sample, $part, true);
					}
					$pending[$ipending]['change_sample'] = EasyParagraph::htmlreadify( EasyParagraph::untrack($change_sample) );
					
					$ipending++;
					
				} else if ( $single_contribution['status'] === 2 ) {
					//so this is a merged contribution...
					$merged[$imerged] = $single_contribution;
					
						//Prepares the author details
					$merged[$imerged]['author'] = Contribution::find($single_contribution['cont_id'])->author ;
					
					$imerged++;
					
				} else if ( $single_contribution['status'] === 3 ) {
					//so this is a rejected contribution
					$retired[$iretired] = $single_contribution;
					
						//Prepares the author details
					$retired[$iretired]['author'] = Contribution::find($single_contribution['cont_id'])->author ;
					
					$iretired++;
					
				}
			}
				
			return View::make('member/story/moderate')
				->with( array(
					'story' => Story::find($sid)->toArray(), 
					'pending' => $pending,
					'merged' => $merged,
					'retired' => $retired
					)				
				);
		} else {
			echo 'Unauthorized to moderate "'. Story::find($sid)->title .'".';
		}
	}

	public function getSettings(){
		return View::make('member/settings');
	}
	

	
}