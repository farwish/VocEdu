<?php

namespace App\Http\Controllers\V1;

use App\Http\Requests\PractiseRecordSave;
use App\Models\Chapter;
use App\Repositories\ChapterRepository;
use App\Repositories\PractiseRecordRepository;
use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PractiseController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/v1/practise/record",
     *      operationId="/api/v1/practise/record—get",
     *      tags={"Practise v1"},
     *      summary="用户`做题记录`基础信息",
     *      description="Get the practise record of User",
     *      security={
     *          {"bearerXxx": {}}
     *      },
     *      @OA\Parameter(
     *          name="Authorization",
     *          description="`Bearer <access_token>`若需调试，统一在顶部 Authorize 中设置",
     *          in="header"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful request",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="data", type="object",
     *                      @OA\Property(property="categoryId", type="integer", description="科目id"),
     *                      @OA\Property(property="categoryName", type="string", description="科目名"),
     *                      @OA\Property(property="chapterName", type="string", description="章节名"),
     *                      @OA\Property(property="questionSerialNumber", type="integer", description="做到第几道题"),
     *                  ),
     *                  @OA\Property(property="message", type="string", default="success"),
     *                  @OA\Property(property="code", type="integer", default=0)
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="data", default=""),
     *              @OA\Property(property="message", type="string", default="登录校验不通过"),
     *              @OA\Property(property="code", type="integer", default=-1)
     *         )
     *      ),
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function recordInfo(Request $request, PractiseRecordRepository $practiseRecordRepository)
    {
        $member = $request->user('api');

        $recordInfo = $practiseRecordRepository->recordInfo($member);

        return $this->success($recordInfo);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/practise/record",
     *      operationId="/api/v1/practise/record-post",
     *      tags={"Practise v1"},
     *      summary="用户`做题记录`保存",
     *      description="Save the practise record of User",
     *      security={
     *          {"bearerXxx": {}}
     *      },
     *      @OA\Parameter(
     *          name="Authorization",
     *          description="`Bearer <access_token>`若需调试，统一在顶部 Authorize 中设置",
     *          in="header"
     *      ),
     *      @OA\Parameter(
     *          name="cid",
     *          description="科目id",
     *          in="query"
     *      ),
     *      @OA\Parameter(
     *          name="pid",
     *          description="章节id",
     *          in="query"
     *      ),
     *      @OA\Parameter(
     *          name="qid",
     *          description="题目id",
     *          in="query"
     *      ),
     *      @OA\Parameter(
     *          name="reply_answer",
     *          description="回答的题目答案",
     *          in="query"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful request",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="data", default=null),
     *                  @OA\Property(property="message", type="string", default="success"),
     *                  @OA\Property(property="code", type="integer", default=0)
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="data", default=""),
     *              @OA\Property(property="message", type="string", default="登录校验不通过"),
     *              @OA\Property(property="code", type="integer", default=-1)
     *         )
     *      ),
     * )
     *
     * @param PractiseRecordSave $request
     * @param ChapterRepository $chapterRepository
     * @param PractiseRecordRepository $practiseRecordRepository
     * @param QuestionRepository $questionRepository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function recordSave(PractiseRecordSave $request,
                               ChapterRepository $chapterRepository,
                               PractiseRecordRepository $practiseRecordRepository,
                               QuestionRepository $questionRepository)
    {
        $validated = $request->validated();

        $categoryId = $validated['cid'] ?? null;
        $chapterId = $validated['pid'] ?? null;

        $questionId = $validated['qid'] ?? null;
        $replyAnswer = $validated['reply_answer'] ?? null;

        $member = $request->user('api');

        // cid,pid 只能传一个
        if (empty($categoryId) && empty($chapterId))  {
            return $this->failure('请传入 cid 或者 pid');
        } else if ($categoryId && $chapterId) {
            return $this->failure('cid 或者 pid 只能传其中一个');
        }

        if ($chapterId) {
            /** @var Chapter $chapter */
            $chapter = $chapterRepository->newQuery()->find($chapterId);
            if ($chapter) {
                $categoryId = $chapter->category()->first()->getAttribute('id');
            } else {
                return $this->failure('chapter 不存在');
            }
        }

        if (! $questionId) {
            $specificRecordInfo = $practiseRecordRepository->specificRecordInfo($member, $categoryId);

            if ($specificRecordInfo) {
                // Find last record its question_id
                $questionId = $specificRecordInfo->getAttribute('question_id');
            } else {
                // Or fill first question_id as default.
                $question = $questionRepository->firstSeriesNumberQuestion($categoryId);
                $questionId = $question ? $question->getAttribute('id') : null;

                if (! $questionId) {
                    return $this->failure('该科目下没有题目 ！');
                }
            }
        }

        // Actually saving.
        $bool = $practiseRecordRepository->recordSave($member, $categoryId, $questionId, $replyAnswer);
        return $bool ? $this->success() : $this->failure();
    }

    /**
     * @OA\Get(
     *      path="/api/v1/practise/summary",
     *      operationId="/api/v1/practise/summary",
     *      tags={"Practise v1"},
     *      summary="用户`做题记录`统计信息",
     *      description="Get the practise summary of User",
     *      security={
     *          {"bearerXxx": {}}
     *      },
     *      @OA\Parameter(
     *          name="Authorization",
     *          description="`Bearer <access_token>`若需调试，统一在顶部 Authorize 中设置",
     *          in="header"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful request",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="data", type="object",
     *                      @OA\Property(property="wrongsCount", type="integer", description="错题数"),
     *                      @OA\Property(property="collectsCount", type="integer", description="收藏数"),
     *                      @OA\Property(property="notesCount", type="integer", description="笔记数"),
     *                  ),
     *                  @OA\Property(property="message", type="string", default="success"),
     *                  @OA\Property(property="code", type="integer", default=0),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="data", default=""),
     *              @OA\Property(property="message", type="string", default="登录校验不通过"),
     *              @OA\Property(property="code", type="integer", default=-1),
     *         )
     *      ),
     * )
     *
     * @param Request $request
     * @param PractiseRecordRepository $practiseRecordRepository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function recordSummary(Request $request, PractiseRecordRepository $practiseRecordRepository)
    {
        $member = $request->user('api');

        $summary = $practiseRecordRepository->recordSummary($member);

        return $this->success($summary);
    }

    /**
     * @OA\Get(
     *      path="/api/v1/practise/current-subject",
     *      operationId="/api/v1/practise/current-subject",
     *      tags={"Practise v1"},
     *      summary="用户当前所选择科目的基础信息",
     *      description="Current subject basic info",
     *      security={
     *          {"bearerXxx": {}}
     *      },
     *      @OA\Parameter(
     *          name="Authorization",
     *          description="`Bearer <access_token>`若需调试，统一在顶部 Authorize 中设置",
     *          in="header"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful request",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="data", type="object",
     *                      @OA\Property(property="categoryName", type="string", description="科目名称"),
     *                      @OA\Property(property="questionsCount", type="string", description="收藏数"),
     *                      @OA\Property(property="openStatus", type="string", description="已开通"),
     *                      @OA\Property(property="expiredAt", type="string", description="到期时间,如: 2021-11-02"),
     *                  ),
     *                  @OA\Property(property="message", type="string", default="success"),
     *                  @OA\Property(property="code", type="integer", default=0),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="data", default=""),
     *              @OA\Property(property="message", type="string", default="登录校验不通过"),
     *              @OA\Property(property="code", type="integer", default=-1),
     *         )
     *      ),
     * )
     *
     * @param Request $request
     * @param PractiseRecordRepository $practiseRecordRepository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function currentSubject(Request $request, PractiseRecordRepository $practiseRecordRepository)
    {
        $member = $request->user('api');

        $currentSubject = $practiseRecordRepository->currentSubjectInfo($member);

        return $this->success($currentSubject);
    }
}
